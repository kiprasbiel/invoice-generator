<?php

namespace App\Models;

use App\Models\Taxes\GPM;
use App\Models\Taxes\SodraTaxes\PSD;
use App\Models\Taxes\SodraTaxes\VSD;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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

    /**
     * The accessors to append to the model's array form.
     *
     * @var arrays
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function invoices() {
        return $this->hasMany('App\Models\Invoice');
    }

    public function meta() {
        return $this->morphMany('App\Models\Meta', 'metable');
    }

    public function getActivitySettings() {
        return $this->meta()->where('name', 'userActivitySettings')->first();
    }

    public function getSfCodeBeginning($json = false) {
        $jsonMeta = $this->meta()->where('name', 'sfNumberSettings')->first();
        if($json) {
            return $jsonMeta;
        } else {
            if($jsonMeta) {
                return json_decode($jsonMeta->value)->sf_code;
            }
            return false;
        }
    }

    public function getTotalIncome() {
        return $this->invoices()->get()->map(function($invoice) {
            return $invoice->getTotalInvoicePrice();
        })->sum();
    }

    public function getTotalExpenses(){
        return 0;
    }

    public function getGPM(){
        $gpm = new GPM($this->getTotalIncome(), $this->getTotalExpenses());
        return $gpm->getCalcGPM();
    }

    public function getVSD(){
        $vsd = new VSD($this->getTotalIncome(), $this->getTotalExpenses());
        return $vsd->getCalcVSD();
    }

    public function getPSD(){
        $psd = new PSD($this->getTotalIncome(), $this->getTotalExpenses());
        return $psd->getCalcPSD();
    }
}
