<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $table = 'comments';
    public $timestamps = true;
    protected $fillable = array('name', 'restaurant_id', 'client_id', 'rating' ,'body');

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

}
