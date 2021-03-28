<?php

namespace App\Models;

use App\Models\Taxes\GPM;
use App\Models\Taxes\SodraTaxes\PSD;
use App\Models\Taxes\SodraTaxes\VSD;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    public function invoices() {
        return $this->hasMany('App\Models\Invoice');
    }

    public function expenses(): HasMany {
        return $this->hasMany('App\Models\Expense');
    }

    public function clients(): HasMany {
        return $this->hasMany('App\Models\Client');
    }

    public function importData(): HasMany {
        return $this->hasMany('App\Models\ImportData');
    }

    public function meta() {
        return $this->morphMany('App\Models\Meta', 'metable');
    }

    public function getUserSettings($settings) {
        return $this->meta()->where('name', $settings)->firstOr(function() use ($settings) {
            throw new Exception($settings . " settings don't exist.");
        });
    }

    public function getPrivilege($privilege){
        $settings = $this->getUserSettings('privilegesSettings');
        if($settings){
            return json_decode($settings->value)->$privilege;
        }
        return false;
    }

    public function getSfCodeBeginning($json = false) {
        $jsonMeta = $this->getUserSettings('sfNumberSettings');
        if($json) {
            return $jsonMeta;
        } else {
            if($jsonMeta) {
                return json_decode($jsonMeta->value)->sf_code;
            }
            return false;
        }
    }

    public function getNextInvoiceNumber(): int{
        return (int)json_decode($this->getUserSettings('sfNumberSettings')->value)
            ->sf_number;
    }

    public function getTotalIncome(): float {
        return $this->invoices()->with('items')->get()->map(function($invoice) {
            return $invoice->total_sum;
        })->sum();
    }

    public function getTotalExpenses(): float {
        return $this->expenses()->with('items')->get()->map(function($expense) {
            return $expense->total_sum;
        })->sum();
    }

    public function getGPM() {
        $gpm = new GPM($this->getTotalIncome(), $this->getTotalExpenses());
        return $gpm->getCalcGPM();
    }

    public function getVSD() {
        $vsd = new VSD($this->getTotalIncome(), $this->getTotalExpenses());
        return $vsd->getCalcVSD();
    }

    public function getPSD(){
        $psd = new PSD($this->getTotalIncome(), $this->getTotalExpenses());
        return $psd->getCalcPSD();
    }

    public function getTotalTax(){
        return $this->getGPM() + $this->getPSD() + $this->getVSD();
    }
}
