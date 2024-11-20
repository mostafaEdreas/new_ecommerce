<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Wishlist extends Model
{
    protected static function booted()
    {
        static::addGlobalScope('hasGroup', function (Builder $builder) {
            $builder->whereHas('group',function($q){
                $q->whereNotNull('price')->where('price','>',0)
                ->whereJsonLength('product_attribute_id', '>', 0)
                ->whereNotNull('product_attribute_id')->whereHas('product');           });
        });
    }
    protected $table = 'wish_lists';
    protected $fillable = ['user_id','group_id'];

    public function group(){
        return $this->belongsTo(Stock::class,'group_id');
    }

    public function getSubTotalProductAttribute(){
        return $this->group->price_details->old_price * $this->quantity ;
    }

    public function getTotalProductAttribute(){
        return $this->group->price_details->new_price  ;
    }

}
