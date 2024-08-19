<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class Restaurant extends Model
{
    use HasApiTokens;
    protected $table = 'restaurants';
    public $timestamps = true;
    protected $fillable = array('email', 'phone', 'password', 'district_id', 'image', 'pin_code', 'contact_phone', 'contact_whats', 'minimum_order', 'delivery_charge', 'status');

    public function district()
    {
        return $this->belongsTo('App\Models\District');
    }
    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function meals()
    {
        return $this->hasMany('App\Models\Meal');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
    }

    public function notifications()
    {
        return $this->morphMany('App\Models\Notification', 'notificationable');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }
    public function notfTokens()
    {
        return $this->hasMany('App\Models\Token');
    }
    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }
    protected $hidden = [
        'password',
        'api_token',
    ];

}
