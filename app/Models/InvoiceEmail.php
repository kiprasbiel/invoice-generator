<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'datetime'
    ];

    public function invoice(): BelongsTo {
        return $this->belongsTo('App\Models\Invoice');
    }
}
