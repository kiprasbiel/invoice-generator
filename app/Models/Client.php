<?php

namespace App\Models;

use App\Http\Traits\Importable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    use Importable;

    protected $fillable = [
        'name',
        'registration_numb',
        'vat_number',
        'address',
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
