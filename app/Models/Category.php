<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['created_at','updated_at'];

    public function parent(){
    return $this->belongsTo('App\Models\Category','parent_id');
  }
    public function child(){
      return $this->hasMany('App\Models\Category', 'parent_id', 'id')->with('child');
  }
  public function parentsRevers(){
    return $this->hasMany('App\Models\Category', 'parent_id', 'parent_id'); 
  }

}
