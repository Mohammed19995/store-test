<?php

namespace App;

use App\Traits\DateFormatTrait;
use App\Traits\Image\ImageTrait;
use App\Traits\User\ScopeUserTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class User extends Authenticatable
{
    use Notifiable , HasMultiAuthApiTokens , SoftDeletes , ImageTrait , DateFormatTrait;

    protected $fillable = [
        'name' ,'phone_code' , 'phone', 'email', 'password','image_id'
    ];
    protected $with = ['get_image'];
    protected $appends = ['image'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    // scopes
    public function scopeCheckPhone($query , $country_code , $phone)
    {
        $query->where('phone_code', '=', $country_code)
            ->where('phone', '=', $phone);
    }
}
