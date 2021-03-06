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
        'seller_vat'
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    protected $appends = ['total_sum'];

    public function meta() {
        return $this->morphMany('App\Models\Meta', 'metable');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function items() {
        return $this->morphMany(Item::class, 'itemable');
    }

    public function getTotalSumAttribute(): float {
        $totalPrice = 0;
        $this->items()->each(
            function($item) use (&$totalPrice) {
                $totalPrice += $item->total_sum;
            }
        );

        return $totalPrice;
    }
}
