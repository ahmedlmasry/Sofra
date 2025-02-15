<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    protected $table = 'cities';
    public $timestamps = true;
    protected $fillable = array('name');

    public function districts()
    {
        return $this->hasMany('App\Models\District');
    }
    public function restaurants(){
        return $this->hasMany('App\Models\Restaurant');
    }

}
