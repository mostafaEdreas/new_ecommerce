<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    //
    protected $table = 'blogcategories';
    public function blogs(){
        return $this->hasMany(BlogItem::class,'blogcategory_id');
    }

    function scopeCheckBeforDelete($query){
        return $query->whereHas('blogs');
    }
}
