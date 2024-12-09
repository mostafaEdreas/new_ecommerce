<?php

namespace App\Http\Controllers;

use App\Helpers\SaveImageTo3Path;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Http\Requests\ProductRequest;
use App\Models\Color;
use App\Models\Brand;
use Picqer;
use App\Models\CategoryColor;
use App\Traits\ImagesTrait;
use App\Traits\products\ProductAjaxTrait;
use App\Traits\products\ProductAttributeTrait;
use App\Traits\products\ProductDiscountTrait;
use App\Traits\products\ProductImageTrait;
use App\Traits\products\productStockTrait;

class ProductController extends Controller
{

    use ProductDiscountTrait, ImagesTrait, ProductAjaxTrait, ProductImageTrait ,productStockTrait ,ProductAttributeTrait;

    public function __construct(){

        $this->middleware(['permission:products']);
    }


    public function index(){
        $products = Product::orderBy('id','DESC')->get();
        return view('admin.products.products',compact('products'));
    }





   
    /////// function return first level sub categories//////
    public function getSubCategories(){
        $categoryId = $_POST['categoryId'];
        $categories=Category::where('parent_id',$categoryId)->get();
        $colorIds= CategoryColor::where('category_id',$categoryId)->pluck('color_id')->toArray();
        $colors = Color::whereIn('id',$colorIds)->get();
        return response()->json(['html' => view('admin.products.subCategories', compact('categories'))->render(),'colors'=>$colors]);
    }

    ////////// function generate barcode///////////
    public function generateBarcode(){

        if($_POST['barcode']){
            $label=$_POST['barcode'];
        }else{
            $label = mt_rand();
        }

        $barcode_generator = new Picqer\Barcode\BarcodeGeneratorPNG();

        $barcode=$barcode_generator->getBarcode($label,$barcode_generator::TYPE_CODE_128 );

        return response()->json([base64_encode($barcode),$label]);
    }

    public function create()
    {
        $data['categories'] = Category::where('status',1)->whereDoesntHave('children')->get();
        $data['brands'] = Brand::where('status',1)->get();
        $data['attributes'] = Attribute::where('status',1)->whereHas('values')->get();
        return view('admin.products.addProduct',$data);
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile("main_image")) {
            $saveImage = new SaveImageTo3Path(request()->file('main_image'),true);
            $fileName = $saveImage->saveImages('products');
            $data['main_image'] = $fileName ;
        }

        if ($request->hasFile("second_image")) {
            $saveImage = new SaveImageTo3Path(request()->file('second_image'),true);
            $fileName = $saveImage->saveImages('products');
            $data['second_image'] = $fileName ;
        }

        $product = Product::create($data) ;

        $product->attributes()->delete();
        foreach ($data['attributes'] ??  [] as  $value) {
            $product->attributes()->create(['attribute_id' => $value]);

        }
        return redirect()->back()->with('success',trans('home.your_produt_added_successfully_upload_images_and_complete_specifications'));
    }

    public function edit($id)
    {
        //
        $product = Product::find($id);

        if($product){
            $data['product'] = $product ;
            $data['categories'] = Category::where('status',1)->whereDoesntHave('children')->get();
            $data['brands'] = Brand::where('status',1)->get();
            $data['attributes'] = Attribute::where('status',1)->whereHas('values')->get();
            return view('admin.products.editProduct',$data);
        }else{
            return redirect()->back()->withErrors(__('home.product not found'));
        }

    }



    public function update(ProductRequest $request, $id){

        $product = Product::find($id);
        $data = $request->validated();
        if ($request->hasFile("main_image")) {
            $saveImage = new SaveImageTo3Path(request()->file('main_image'),true);
            $fileName = $saveImage->saveImages('products');
            $data['main_image'] = $fileName ;
        }

        if ($request->hasFile("second_image")) {
            $saveImage = new SaveImageTo3Path(request()->file('second_image'),true);
            $fileName = $saveImage->saveImages('products');
            $data['second_image'] = $fileName ;
        }

        $product->update( $data);

        $product->attributes()->delete();
       
        foreach ($data['attributes'] ??  [] as $key => $value) {
            $product->attributes()->create(['attribute_id' => $value]);

        }

        return redirect()->back()->with('success',trans('home.product_data_updated_successfully'));
    }

    public function destroy($id){
        if( request('id')){
            request()->validate([
                'id' => 'array|min:1|',
                'id.*' => 'exists:products,id'
            ]);
            $ids =  request('id') ;
            $delete = Product::whereIn('id',$ids)->delete();
            // check if comming from ajax
            if(request()->ajax()){
                // check is is deleted or has any exception
                if( !$delete ){
                    return response()->json(['message'=> $delete??__('home.an messages.error entering data')],422);
                }
                return response()->json(['message'=>trans('home.your_items_deleted_successfully')]);
            }
            if( !$delete ){
                return redirect()->back()->withErrors( $delete??__('home.an error has occurred. Please contact the developer to resolve the issue'));
            }
            return redirect()->back()->with('success',trans('home.your_items_deleted_successfully'));
        }elseif($aboutStruc = Product::find($id)){
               // check is is deleted or has any exception
               $delete = $aboutStruc->delete();
            if(request()->ajax()){
                if( !$delete ){
                    return response()->json(['message'=> $delete??__('home.an messages.error entering data')],422);
                }
                return response()->json(['message'=>trans('home.your_item_deleted_successfully')]);
            }
            if( !$delete ){
                return redirect()->back()->withErrors( $delete??__('home.an error has occurred. Please contact the developer to resolve the issue'));
            }
            return redirect()->back()->with('success',trans('home.your_item_deleted_successfully'));
        }
    }




}
