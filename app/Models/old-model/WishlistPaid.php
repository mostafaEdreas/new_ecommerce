<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class WishlistPaid extends Model
{
    protected $table = 'wishlist_paid';


    public  function product(){
        return $this->belongsTo('App\Models\Product');
    }
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
