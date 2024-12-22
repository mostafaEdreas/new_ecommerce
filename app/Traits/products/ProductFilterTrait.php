<?php
namespace App\Traits\Products;

use Illuminate\Database\Eloquent\Builder;
use ReflectionClass;

trait ProductFilterTrait {

    public function scopeFilterProduct($query) {

        $methods = (new ReflectionClass($this))->getMethods(\ReflectionMethod::IS_PRIVATE);

        foreach ($methods as $method) {

            if ($method->class === __CLASS__ && str_starts_with($method->name, 'by')) {

                $this->{$method->name}($query);
            }
        }
    }

    private function byValue(Builder $product) {
        $value = request('value');
        if ($value) {
            $product->with(['attributes' => function ($query) use ($value) {
                $query->whereHas('values', function($q) use($value){
                    $q->where('value_id',$value);
                });
            }])->whereHas('attributes', function ($query) use ($value) {
                $query->whereHas('values', function($q) use($value){
                    $q->where('value_id',$value);
                });
            });
        }
    }


    private function byMinPrice( Builder $product) {
        $min_price = request('min_price');

        if ($min_price) {
            $product->with(['stocks' => function ($query) use ($min_price) {
                $query->where('price', '>=' , $min_price);
            }])->whereHas('stocks' , function ($query) use ($min_price) {
                $query->where('price', '>=' , $min_price);
            });
        }
    }

    private function byMaxPrice( Builder $product) {
        $max_price = request('max_price');
        if ($max_price) {
            $product->with(['stocks' => function ($query) use ($max_price) {
                $query->where('price', '<=' , $max_price);

            }])->whereHas('stocks' , function ($query) use ($max_price) {
                $query->where('price', '<=' , $max_price);
            });
        }
    }


}
