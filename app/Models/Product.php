<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Models\ProductAttribute;
use App\Traits\Products\ProductFilterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Maatwebsite\Excel\Concerns\ToArray;


class Product extends Model
{
    use HasFactory , ProductFilterTrait;
    protected $table = 'products' ;
    private $lang ;

    protected $fillable = [
        'name_ar',
        'name_en',
        'category_id',
        'brand_id',
        'code',
        'order',
        'text_ar',
        'text_en',
        'short_text_ar',
        'short_text_en',
        'main_image',
        'second_image',
        'icon',
        'status',
        'link_ar',
        'link_en',
        'mete_title_ar',
        'mete_title_en',
        'mete_description_ar',
        'mete_description_en',
        'index',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Set the current locale dynamically
        $this->lang = Helper::getLang();

    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->code)) {
                $product->code = self::generateProductCode();
            }
        });
    }

    public function delete()
    {
        $errors = [] ;
        if ($this->stocks()->exists()) {
          foreach ($this->stocks as  $stock) {
            if ($stock->orders()->exists()) {
                $errors[] = __('home.cannot delete an product that has related orders');
            }
          }
        }

        if(count( $errors)){
            return $errors;
           }
        return parent::delete();
    }

    public static function generateProductCode()
    {
        $latestProduct = self::orderBy('id', 'desc')->first();
        $latestId = $latestProduct ? $latestProduct->id : 0;
        return config('site_perfix') . str_pad($latestId + 1, 4, '0', STR_PAD_LEFT);
    }
    public function getNameAttribute(){
        return $this->{'name_'.$this->lang} ;
    }

    public function getTextAttribute(){
        return $this->{'text_'.$this->lang} ;
    }

    public function getLinkAttribute(){
        return $this->{'link_'.$this->lang} ;
    }

    public function getShortTextAttribute(){
        return $this->{'short_text_'.$this->lang} ;
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function getBrandNameAttribute(){
        return $this->brand?->name;
    }

    public function getBrandTextAttribute(){
        return $this->brand?->text;
    }

    public function getBrandLinkAttribute(){
        return $this->brand?->link;
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }



    public function getCategoryNameAttribute(){
        return $this->category?->name;
    }

    public function getCategoryTextAttribute(){
        return $this->category?->text;
    }

    public function getCategoryLinkAttribute(){
        return $this->category?->link;
    }


    public function getMainImageSourceAttribute($value){

        return Helper::imageIsExists($this->main_image ,'products') ? Helper::uploadedImagesPath('products',$this->main_image)   : Helper::noImage() ;

    }

    public function getMainImage200Attribute($value){

        return Helper::imageIsExists($this->main_image ,'products') ? Helper::uploadedImages200Path('products',$this->main_image)  : Helper::noImage() ;
    }

    public function getSecondImageSourceAttribute(){

        return Helper::imageIsExists($this->second_image ,'products') ? Helper::uploadedImagesPath('products',$this->second_image)  : Helper::noImage() ;
    }

    public function getSecondImage200Attribute(){

        return Helper::imageIsExists($this->second_image ,'products') ? Helper::uploadedImages200Path('products',$this->second_image)  : Helper::noImage() ;
    }

    public function images(){

        return $this->morphMany(Image::class,'imageable'); ;
    }

    public function getActiveAttribute(){
        $this->status ? __('home.yes') : __( 'home.no') ;
     }

    public function scopeActive($query){
        $query->whereStatus(1);
    }

    public function scopeUnactive($query){
        $query->whereStatus(0);
    }

    public function attributes(){
        return $this->hasMany(ProductAttribute::class);
    }
    public function stocks(){
        return $this->hasMany(ProductStock::class)->orderBy('stock' ,'desc');
    }

    public function getStockAttribute(){
        return $this->stocks[0] ?? null;

    }

    public function getQuantityAttribute(){
        return $this->stock?->stock  ;
    }
    public function getNetPriceAttribute(){
        return $this->stock?->net_price  ;
    }

    public function getAvailableAttribute(){
        return $this->stock?->stock  ;
    }

    public function discounts(){
        return $this->hasMany(Discount::class);
    }


    public function getDiscountIdAttribute(){
        return $this->discount?->id;
    }
    public function discount(){
        return $this->hasOne(Discount::class)
        ->where('start_date', '<=', now()->startOfDay())
        ->where('end_date', '>=', now()->startOfDay())
        ->orderByDesc('start_date') // Ensure the latest valid discount is prioritized
        ->latestOfMany();
    }

    public function getDiscountTypeAttribute(){
        return $this->discount?->type ;
    }

    public function getDiscountValueAttribute(){
        return $this->discount?->discount ;
    }

    public function getAttributeValuesAttribute(){
        $product_Attributes_id = $this->attributes()->pluck('id')->ToArray();
        return ProductAttributeValue::whereIn('product_attribute_id' , $product_Attributes_id)->get();
    }

    public function scopeHasStock($query){
        return $query->whereHas('stocks');
    }

    public function scopeByCategory($query , int $category_id){
        return $query->where('category_id' ,$category_id);
    }


    public function reviews($query){
        return $this->hasMany(ProductReview::class);
    }

    public function getReviewsCountAttribute(){
        return $this->reviews->count();
    }

}
