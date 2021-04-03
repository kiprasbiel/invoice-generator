<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportData extends Model
{
    use HasFactory;

    protected $fillable = [
        'csv_filename',
        'csv_header',
        'csv_data',
        'type',
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
