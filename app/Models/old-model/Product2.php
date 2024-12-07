<?php

namespace App\Models;
use App\Models\ProductDiscount;
use App\Models\ProductImage;
use App\Models\CartProduct;
use App\Models\ProductReview;
use App\Models\Wishlist;
use Carbon\Carbon;
use App\Models\ProductAttribute;
use App\Models\Attribute;
use App\Models\ProductColor;
use App\Models\Color;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product2 extends Model
{
    public function productAttributs(){
        return $this->hasMany(ProductAttribute::class);
    }

    public function Groups(){
        return  $this->hasMany(Stock::class);
        ;
    }

    public function groupsUesr(){
        return  $this->hasMany(Stock::class)
        ->whereNotNull('price')->where('price','>',0)
        ->whereJsonLength('product_attribute_id', '>', 0)
        ->whereNotNull('product_attribute_id') ;
    }
    public function images(){
        $images= ProductImage::where('product_id',$this->id)->orderBy('id','desc')->get();
        $images = count($images) > 0?$images:[];
        return $images;
    }


    public function firstImage(){
        return ProductImage::where('product_id',$this->id)->orderBy('id','desc')->first()??(object)['image'=>null];
    }

    public function brand(){
        return $this->belongsTo(Brand::class,'brand_id');
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function attributes(){
        return $this->belongsToMany(Attribute::class,'product_attributes')->distinct();
    }

    public function lessPriceByGroub(){
        //->groupBy(DB::raw('JSON_UNQUOTE(product_attribute_id)'))
        $builder = $this->groupsUesr()->orderBy('price');
        if (request('size_id')) {
            $size_attribute_value_id = $this->productAttributs()->where('attribute_value_id', request('size_id'))->first('id');
            $builder->whereJsonContains('product_attribute_id', (string) $size_attribute_value_id->id);
        }
        if(request('has_stock')){ $builder->where('stock','>',0);}
        if(request('min')){ $builder->where('price','>=',request('min'));}
        if(request('max')){ $builder->where('price','<=',request('max'));}
        if(request('group')){ $builder->where('id',request('group'));}
        $builderCol = $builder->get();
        foreach ($builderCol as $value) {
            if($value->stock > 0){
                return $value;
            }
        }
        return $builder->first();
    }

    public function cart(){
        $cart = CartProduct::where('user_id',auth()->user()->id)->where('product_id',$this->id)->count();
        return $cart;
    }

    public function reviews(){
        return $this->hasMany(ProductReview::class);
    }

    public function wishlist(){
        $wishlist = Wishlist::where('user_id',auth()->user()->id)->where('product_id',$this->id)->count();
        return $wishlist;
    }

    public function getRateAttribute($rate){
        $product_reviews = ProductReview::where('product_id',$this->id) ;
        $total_admin_rate = $rate?($rate * 5) : 0 ;
        $total_product_reviews = $product_reviews->sum('rate');
        $total_rate =  $total_admin_rate + $total_product_reviews ;
        $count =  $product_reviews->count('rate') + ($rate??0) ;
        $final_rate = $total_rate /  ($count== 0?1: $count) ;
        $rate_desc = __('home.doesn\'t have rate') ;
        $percentage =$total_rate > 0 &&$count > 0 ?( $total_rate / ($count * 5)) * 100:0;
        $count_hight_rate =  $product_reviews->whereIn('rate',[5,4])->count('rate') + $rate ;
        if ($final_rate > 0 && $final_rate < 2 ) { $rate_desc = __('home.bad');}
        elseif ($final_rate >= 2 && $final_rate < 3 ) { $rate_desc = __('home.not bad');}
        elseif ($final_rate >= 3 && $final_rate < 4 ) { $rate_desc = __('home.good');}
        elseif ($final_rate >= 4 && $final_rate < 5 ) { $rate_desc = __('home.very good');}
        elseif ($final_rate >= 5 ) { $rate_desc = __('home.excellent');}
        return (object) ['count'=> $count,'rate'=> round($final_rate, 1) ,'text_rate'=>$rate_desc ,'percentage' =>round($percentage, 1),'count_hight_rate'=>$count_hight_rate ];
    }


    public function discount(){
        return $this->hasOne(ProductDiscount::class);
    }


    // public function getImageAttribute(){
    //     $images_ids = Stock::where('product_id',$this->id)->pluck('image_id')->toArray();
    //     $images_ids = array_unique($images_ids);
    //     return ProductImage::where('product_id',$this->id)->first()?->image;
    // }

    public function productStartPrice(){
        return ProductPrice::where('product_id',$this->id)->get();
    }

    public function colors(){
        $colorIds = ProductColor::where('product_id',$this->id)->pluck('color_id')->toArray();
        $colors = Color::whereIn('id',$colorIds)->get();
        return $colors;
    }

    public function reviewCount(){
        return ProductReview::where('product_id',$this->id)->count();
    }

    public function discountPercentage(){
        $productDiscount= ProductDiscount::where('product_id',$this->id)->first();
        $product=Product::find($this->id);
        return intval((($productDiscount->value)*100)/$product->price );
    }

    public function hot_offer(){
        $productDiscount=ProductDiscount::where('product_id',$this->id)->first();

        if($productDiscount && Carbon::now()->between(Carbon::parse($productDiscount->start_date), Carbon::parse($productDiscount->end_date))){
            return true;
        }else{
            return false;
        }
    }

    public function condition_discount(){
        $productDiscount=ProductDiscount::where('product_id',$this->id)->first();
        $product=Product::find($this->id);
        $product_price=$product->price;
        $discount=0;
        if($productDiscount && Carbon::now()->between(Carbon::parse($productDiscount->start_date), Carbon::parse($productDiscount->end_date))){
            if ($productDiscount->value_type=='value'){
                $discount=$product_price-$productDiscount->value;
            }else{
                $discount=$product_price- (($productDiscount->value*$product_price)/100);
            }
        }
        return $discount;
    }

    public function condition_discount_product_page($attribute_id=null){
        $productDiscount=ProductDiscount::where('product_id',$this->id)->first();
        $product=Product::find($this->id);
        $product_price=$product->price;
        if(count($product->price_options)>0){
            if($attribute_id){
                $product_price = ProductOption::where('product_id',$this->id)->where('attribute_value_id',$attribute_id)->first()->price;
            }else{
                $product_price = $product->price_options[0]->price;
            }
        }
        $discount=0;
        if($productDiscount && Carbon::now()->between(Carbon::parse($productDiscount->start_date), Carbon::parse($productDiscount->end_date))){
            if ($productDiscount->value_type=='value'){
                $discount=$product_price-$productDiscount->value;
            }else{
                $discount=$product_price- (($productDiscount->value*$product_price)/100);
            }
        }else{
            $discount=$product_price;
        }
        return $discount;
    }
    public function old_price_product_with_attribute($attribute_id=null){
        $product=Product::find($this->id);
        $product_price=$product->price;
        if(count($product->price_options)>0){
            if($attribute_id){
                $product_price = ProductOption::where('product_id',$this->id)->where('attribute_value_id',$attribute_id)->first()->price;
            }else{
                $product_price = $product->price_options[0]->price;
            }
        }
        return $product_price;
    }

    public function new(){
        $productDiscount=Product::where('id',$this->id)->first();
        $currentDateTime = Carbon::now();
        $productUpdatedAt = Carbon::parse($productDiscount->updated_at);
        $monthsDifference = $currentDateTime->diffInMonths($productUpdatedAt);
        if($monthsDifference<1 ){
            return true;
        }else{
            return false;
        }
    }
    public function stockCount(){
      return Product::where('id',$this->id)->first()->stock;
    }
    public function quantity_sold(){
        return OrderProduct::where('product_id',$this->id)->sum('quantity');
    }

    public function orders(){
        return $this->hasMany(OrderProduct::class);
    }


    public function quantity_search(){
        $record = Frequently_search::where('product_id',$this->id)->first();
        if(isset($record)){
            return $record->count_search;
        }
        else{
            return 0;
        }
    }

    public function rate_percentage($n){
        $all_rates_n = ProductReview::where('product_id',$this->id)->count();
        if($all_rates_n>0){
        $productRate_n = ProductReview::where('product_id',$this->id)->where('rate',$n)->count();
        return  intval((($productRate_n)*100)/$all_rates_n );
        }else{
            return 0;
        }


    }

    public function price_options(){
        return $this->hasMany(ProductOption::class);
    }

    public function attribute_value($attribute_id){
        return AttributeValue::find($attribute_id);
    }

    public function avilableGroupValue($stock_id){
        Stock::finde($stock_id);
    }

    private function getLessPriceWithAttribute(){
        $product_price = $this->price;
        $attribute_ids = $this->attributes()->pluck('attribute_id')->toArray();
        $attributeValue = AttributeValue::whereIn('attribute_id', $attribute_ids)->orderBy('price')->first();
        $attribute_price = $attributeValue ? $attributeValue->price : null;
        $groupPrice = $this->stock()->whereNotNull('price')->orderBy('price')->first();
        $groupPrice = $groupPrice ? $groupPrice->price : null;

        $product_attribute_id = $this->attributes()->pluck('id')->toArray();
        $product_attribute_ids_in_stock = array_unique(array_merge(...$this->stock()->whereNotNull('price')->pluck('product_attribute_id')->toArray()));
        $freeProductAttribute = array_intersect($product_attribute_id, $product_attribute_ids_in_stock);

        if ($product_price <  $attribute_price && $product_price <  $groupPrice && count($freeProductAttribute)) {
            return (object) ['price'=>$product_price];
        }elseif ($attribute_price <  $groupPrice && $attribute_price  < $product_price && count($freeProductAttribute) ) {

        }else{
            return 0 ;
        }
    }


    function scopeCheckBeforDelete($query) {
        return $query->whereHas('orders') 
        ->whereHas('productAttributs')
        ->whereHas('groups')
        ->whereHas('images');
    }
}
