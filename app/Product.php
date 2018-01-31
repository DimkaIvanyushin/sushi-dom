<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'weight', 'price', 'composition', 'category_id', 'pictures'];

  	public function category()
  	{
    	return $this->belongsTo(Category::class);
  	}

    public function likes()
    {
        return $this->belongsToMany('App\User','likes');
    }

}
