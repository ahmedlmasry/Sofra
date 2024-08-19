<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class Client extends Model
{
    use HasApiTokens;
    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array( 'name', 'email', 'phone', 'password', 'district_id', 'image', 'pin_code', 'status');

    public function district()
    {
        return $this->belongsTo('App\Models\District');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function notifications()
    {
        return $this->morphMany('App\Models\Notification', 'notificationable');
    }
    protected $hidden = [
        'password',
        'api_token',
    ];
}
