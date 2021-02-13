<?php

namespace App\Models;

use App\Http\services\pdf\PdfGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\This;

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
            $query->sf_number = self::calculateLatestSfNumber();
            $query->sf_code = self::generateSfCode();
        });
    }


    private static function calculateLatestSfNumber(){
        $lastInvoice = DB::table('invoices')->where('user_id', auth()->user()->id)->latest()->first();
        if($lastInvoice){
            $currantNum = $lastInvoice->sf_number;
            return $currantNum + 1;
        }
        return 1;
    }

    private static function generateSfCode(){
        $sFBeginning = auth()->user()->getSfCodeBeginning();
        $newNumber = self::calculateLatestSfNumber();
        return "$sFBeginning $newNumber";
    }

    // TODO: Perkelt i booted, jei veikia
    protected static function boot() {
        parent::boot();
        self::deleting(function($invoice){
            $invoice->invoiceItems()->get()->map(function($item){
                $item->delete();
            });
        });
    }

    // TODO Add default values: is_payed, is_sent
    protected $attributes = [
        'sf_number' => 1,
        'sf_code' => 'SF1',
    ];

    public function meta()
    {
        return $this->morphMany('App\Models\Meta', 'metable');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function invoiceItems(){
        return $this->hasMany('App\Models\InvoiceItem');
    }

    public function getTotalInvoicePrice(){
        $totalPrice = 0;
        $this->invoiceItems->each(
            function($item) use (&$totalPrice){
                $totalPrice += $item->getTotalPrice();
            }
        );

        return $totalPrice;
    }

    public function downloadInvoice(){
        $generator = new PdfGenerator($this, $this->invoiceItems);
        return $generator->downloadPdf();
    }
}
