<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InvoiceEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'datetime'
    ];

    public function invoice(): HasOne {
        return $this->hasOne('App\Models\Invoice');
    }
}
