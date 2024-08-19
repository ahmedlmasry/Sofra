<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MO extends Model
{

    protected $table = 'meal_order';
    public $timestamps = true;
    protected $fillable = array('meal_id', 'order_id', 'price', 'quantity', 'special_note');

}
