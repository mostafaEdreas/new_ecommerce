<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    protected $table = 'order_status';
    protected $fillable = ['order_id','status'];
    public const STATUS =  ['pending','accept','process','shipping','delivered','canceled'] ;

    public function order (){
        return $this->belongsTo(Order::class);
    }
}
