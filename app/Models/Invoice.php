<?php

namespace App\Models;

use App\Http\services\pdf\PdfGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_code',
        'company_address',
        'company_vat',
        'pay_by',
    ];

    protected $casts = [
        'pay_by' => 'datetime'
    ];

    protected static function booted()
    {
        static::creating(function ($query) {
            $query->sf_number = auth()->user()->getNextInvoiceNumber();
            $query->sf_code = self::generateSfCode();
        });
    }

    private static function generateSfCode(){
        $user = auth()->user();
        $sFBeginning = $user->getSfCodeBeginning();
        $newNumber = $user->getNextInvoiceNumber();
        return "$sFBeginning $newNumber";
    }

    // TODO: Perkelt i booted, jei veikia
    protected static function boot() {
        parent::boot();
        self::deleting(function($invoice){
            $invoice->items()->get()->map(function($item) {
                $item->delete();
            });
        });
    }

    // TODO Add default values: is_payed, is_sent

    public function meta() {
        return $this->morphMany('App\Models\Meta', 'metable');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function items() {
        return $this->morphMany(Item::class, 'itemable');
    }

    public function getTotalInvoicePrice(): float {
        $totalPrice = 0;
        $this->items->each(
            function($item) use (&$totalPrice) {
                $totalPrice += $item->getTotalPrice();
            }
        );

        return $totalPrice;
    }

    public function downloadInvoice(){
        $generator = new PdfGenerator($this, $this->items);
        return $generator->downloadPdf();
    }
}
