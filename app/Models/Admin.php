<?php

namespace App\Models;

use App\Traits\DateFormatTrait;
use App\Traits\Image\ImageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use SoftDeletes , ImageTrait , DateFormatTrait;

    protected $table = 'admins';
    protected $fillable = ['name' ,'phone_code' ,'phone', 'email' ,'image_id' ,'password' , 'is_super' , 'status'];
    protected $with = ['get_image'];
    protected $appends = ['image'];

}
