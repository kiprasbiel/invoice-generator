<?php

namespace App\Models;

use App\Http\services\pdf\PdfGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $totalCost;

    protected $fillable = [
        'company_name',
        'company_code',
        'company_address',
        'company_vat',
    ];

    // TODO Add default values: is_payed, is_sent
//    protected $attributes = [
//        'delayed' => false,
//    ];

    public function meta()
    {
        return $this->morphMany('App\Models\Meta', 'metable');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function downloadInvoice(){
        $generator = new PdfGenerator($this, $this->meta()->where('name', 'invoiceServices')->first());
        return $generator->downloadPdf();
    }
}
