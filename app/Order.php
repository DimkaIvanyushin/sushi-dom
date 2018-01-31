<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $fillable = ['name', 'cart', 'phone', 'street', 'house', 'apartment', 'housing', 'entrance', 'floor', 'comment', 'confirmed', 'user_id'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
