<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit',
        'quantity',
        'price',
    ];

    protected $attributes = [
        'unit' => '.vnt',
        'quantity' => 1
    ];

    public function itemable() {
        return $this->morphTo();
    }

    public function getTotalPrice() {
        return $this->quantity * $this->price;
    }
}
