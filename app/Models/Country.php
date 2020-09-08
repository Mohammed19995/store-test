<?php

namespace App\Models;

use App\Traits\Image\FlagTrait;
use App\Traits\LanguageTrait;
use App\Traits\Model\GlobalScopeTrait;
use App\Traits\TranslateTrait;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use TranslateTrait , FlagTrait;

    protected $table = 'countries';
    protected $fillable = ['name_ar' , 'name_en' ,'flag_id' ,'iso2' , 'iso3','currency_id','phone_code'];

    protected $with = ['get_flag'];
    public $appends = ['name' ,'flag'];


    // scope
    public function scopeActive($query) {
        $query->where('status' , '=' , 1);
    }

    // relation
    public function currency() {
        return $this->belongsTo(Currency::class , 'currency_id');
    }
}
