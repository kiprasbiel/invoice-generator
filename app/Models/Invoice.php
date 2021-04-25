<?php

namespace App\Models;

use App\Http\services\pdf\PdfGenerator;
use App\Http\Traits\Importable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Invoice extends Model
{
    use HasFactory;
    use Importable;

    protected $fillable = [
        'company_name',
        'company_code',
        'company_address',
        'company_vat',
        'pay_by',
    ];

    protected $importFillable = [
        'created_at',
        'sf_code',
    ];

    protected $casts = [
        'pay_by' => 'datetime'
    ];

    protected $appends = ['total_sum'];

    protected static function booted() {
        static::creating(function ($query) {
            $query->sf_number = auth()->user()->getNextInvoiceNumber();
            $query->sf_code = self::generateSfCode();
        });
    }

    private static function generateSfCode(): string {
        $user = auth()->user();
        $sFBeginning = $user->getSfCodeBeginning();
        $newNumber = $user->getNextInvoiceNumber();
        return "$sFBeginning $newNumber";
    }

    // TODO: Perkelt i booted, jei veikia
    protected static function boot() {
        parent::boot();
        self::deleting(function ($invoice) {
            $invoice->items()->get()->map(function ($item) {
                $item->delete();
            });
        });
    }

    // TODO Add default values: is_payed, is_sent

    public function meta(): MorphMany {
        return $this->morphMany('App\Models\Meta', 'metable');
    }

    public function user(): BelongsTo {
        return $this->belongsTo('App\Models\User');
    }

    public function items(): MorphMany {
        return $this->morphMany(Item::class, 'itemable');
    }

    public function email(): HasOne {
        return $this->hasOne('App\Models\InvoiceEmail');
    }

    public function getTotalSumAttribute(): float {
        $totalPrice = 0;
        $this->items()->each(
            function ($item) use (&$totalPrice) {
                $totalPrice += $item->total_sum;
            }
        );

        return $totalPrice;
    }

    public function downloadInvoice(): StreamedResponse {
        $generator = new PdfGenerator($this, $this->items);
        return $generator->downloadPdf();
    }

    public function getInvoice(): array {
        $generator = new PdfGenerator($this, $this->items);
        return $generator->getPDF();
    }
}
