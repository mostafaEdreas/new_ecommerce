<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discount extends Model
{

    use HasFactory;
    protected $table = 'discounts';

    protected $fillable = [
        'start_date',
        'end_date',
        'discount',
        'type',
        'product_id',
    ];

    public function delete()
    {
        $errors = [] ;
        if ($this->can_delete_or_update) {
            $errors[] = __('home.cannot delete an discount that is  used');
        }

        if(count( $errors)){
                return $errors;
           }
           return parent::delete();
    }

    public function product(){
        return $this->belongsTo(product::class);
    }

    public function getIsAvailableAttribute(){
        return $this->start_date >= date('Y-m-d') &&  $this->end_date <= date('Y-m-d') ;
    }


    public function getDiscountTypeAttribute(){
        return $this->type?__( 'home.percentage')  : __('home.amount');
    }

    public function getCanEditOrDeleteAttribute(){
         return OrderProduct::where('discount_id', $this->id)->count() === 0;
    }
}
