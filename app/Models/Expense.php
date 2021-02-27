<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'date',
        'currency',
        'seller_name',
        'seller_code',
        'seller_address',
        'seller_vat',
        'seller_country',
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    public function meta() {
        return $this->morphMany('App\Models\Meta', 'metable');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function invoiceItems() {
        return $this->hasMany('App\Models\InvoiceItem');
    }
}
