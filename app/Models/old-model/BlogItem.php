<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogItem extends Model
{
    //
    protected $table = 'blogitems';
    public function Blogcat()
    {
        return $this->belongsTo('App\Models\BlogCategory','blogcategory_id','id');
    }
}
