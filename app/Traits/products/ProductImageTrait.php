<?php
namespace App\Traits\Products;

use App\Http\Requests\ImageRequest;
use App\Models\Product;

trait ProductImageTrait {


    public function getImages($id){
        $product = Product::with('images')->find($id) ;
        if( $product){
           $data['parent'] = $product ;
           $data['remove_url'] = route('products.images.remove',$product->id) ;
           $data['upload_url'] = route('products.images.upload',$product->id) ;

           return view('admin.products.images.index',$data);

        }

    }
    public function uploadImages(ImageRequest $request,$id){
        $product = Product::find($id) ;
        if( $product){
            $response =  $this->saveImages($request, $product) ;
            return $response
            ? redirect()->back()->with( 'success',__('home.your_items_added_successfully'))
            : redirect()->back()->withErrors($response);
        }
        return redirect()->back()->withErrors(__('home.not_found'));
    }
}
