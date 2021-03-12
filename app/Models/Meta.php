<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    use HasFactory;

    protected $table = 'meta';

    protected $fillable = [
        'name',
        'value',
    ];

    public function metable()
    {
        return $this->morphTo();
    }

    public static function getIvSettingsFields(){
        return [
            'full_name',
            'iv_code',
            'personal_code',
            'address',
            'phone',
            'email',
            'additional_info',
            'bank_name',
            'bank_account_num',
            'vat',
        ];
    }

    public static function getSfCodeSettingsFields(){
        return [
            'sf_code',
            'sf_number',
        ];
    }

    public static function getPrivilegesSettingsFields(){
        return [
            'isStudent',
            'isFirstTimer',
            'isPensioner',
            'additionalPension',
            'isFreeMarketActivity'
        ];
    }

    public static function getFieldsForValidation($fields, $fill = 'nullable'){
        $methodName = 'get' . $fields . 'SettingsFields';
        $actualFields = self::$methodName();
        return array_fill_keys($actualFields, $fill);
    }
}
