<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = array('restaurant_id', 'payment_method', 'note', 'total_price', 'state', 'client_id', 'address', 'delivery_charge', 'commission');

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

    public function meals()
    {
        return $this->belongsToMany('App\Models\Meal')->withPivot('quantity','price','special_note');
    }

}
