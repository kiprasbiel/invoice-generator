<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit',
        'quantity',
        'price',
        'invoice_id',
    ];

    protected $attributes = [
        'unit' => '.vnt',
        'quantity' => 1
    ];

    public function invoice(){
        return $this->belongsTo('App\Models\Invoice');
    }

    public function getTotalPrice(){
        return $this->quantity * $this->price;
    }
}
