<?php

namespace App\Http\Controllers;

use App\Helpers\SaveImageTo3Path;
use App\Models\Product;
use App\Models\Category;
use App\Models\CategoryAttribute;
use App\Models\Attribute;

use App\Models\Color;
use App\Models\Brand;
use App\Models\ProductImage;
use App\Models\ProductAttribute;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use Picqer;
use App\Models\ProductDiscount;

use App\Models\CategoryColor;


use Excel;
use App\Imports\ProductPriceListImport;
use App\Models\AttributeValue;
use App\Models\Stock;
use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ProductController extends Controller
{


    public function __construct(){

        $this->middleware(['permission:products']);
    }


    public function index(){
        $products = Product::orderBy('id','DESC')->get();
        return view('admin.products.products',compact('products'));
    }

    /////// function return first level sub categories//////
    public function getSubCategories(){
        $categoryId=$_POST['categoryId'];
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
        $data['attributes'] = Attribute::where('status',1)->get();
        return view('admin.products.addProduct',$data);
    }

    public function store(Request $request)
    {
        $add = new Product();
        $add->category_id = $request->category_id;
        $add->name_en = $request->name_en;
        $add->name_ar = $request->name_ar;
        $add->short_desc_en = $request->short_desc_en;
        $add->short_desc_ar = $request->short_desc_ar;
        $add->long_desc_en = $request->long_desc_en;
        $add->long_desc_ar = $request->long_desc_ar;
        $add->char_desc_ar = $request->char_desc_ar;
        $add->char_desc_en = $request->char_desc_en;

        $add->link_en = str_replace(" ","-",$request->link_en??$request->name_en);
        $add->link_ar = str_replace(" ","-",$request->link_ar??$request->name_ar);
        $add->brand_id = $request->brand_id;
        $add->code = $request->code;
        $add->ean = $request->ean;
        $add->rate = $request->rate;
        $add->barcode = $request->barcode;
        $add->sku_code = $request->sku_code;
        $add->admin_comment = 'admin added new product';
        $add->admin_seen = 1;
        $add->meta_title_en = $request->meta_title_en;
        $add->meta_desc_en = $request->meta_desc_en;
        $add->meta_title_ar = $request->meta_title_ar;
        $add->meta_desc_ar = $request->meta_desc_ar;
        $add->meta_robots = $request->meta_robots ;
        $add->save();

        /////// add product colors///////
        // $colorIds = $request->color_id;
        // foreach($colorIds as $colorId){
        //     $productColor = new ProductColor();
        //     $productColor->product_id = $add->id;
        //     $productColor->color_id = $colorId;
        //     $productColor->save();
        // }

        return redirect('admin/products/'.$add->id.'/edit')->with('success',trans('home.your_produt_added_successfully_upload_images_and_complete_specifications'));
    }

    public function edit($id)
    {
        //
        $product = Product::find($id);
        $data['product'] = $product ;
        if($product){
            // $category = Category::find($product->category_id);
            // $productColorIds = ProductColor::where('product_id',    $id)->pluck('color_id')->toArray();
            // $productColors = Color::whereIn('id',$productColorIds)->get();
            $data['categories'] = Category::where('status',1)->whereDoesntHave('subCategories')->get();
            // $colorIds = CategoryColor::where('category_id',$product->category_id)->pluck('color_id')->toArray();
            // $colors=Color::whereIn('id',$colorIds)->where('status',1)->get();
            $data['brands'] = Brand::where('status',1)->get();
            // $barcode_generator = new Picqer\Barcode\BarcodeGeneratorPNG();
            // $barcode=$barcode_generator->getBarcode($product->barcode,$barcode_generator::TYPE_CODE_128 );
            // $categoryAttributeIds = CategoryAttribute::where('category_id',$category->id)->pluck('attribute_id')->toArray();
            // $attributes=Attribute::whereIn('id',$categoryAttributeIds)->get();
            // $adAttributeValueIds = ProductAttribute::where('product_id',$id)->pluck('attribute_value_id')->toArray();
            // $productDiscount = ProductDiscount::where('product_id',$id)->first();
            // $productOptions = ProductOption::where('product_id',$id)->get();
            // $productQuantityPrices = ProductPrice::where('product_id',$id)->get();

            $images = DB::table('temp_upload_files')->where('product_id',$id)->get();
            if(count($images) > 0){
                foreach($images as $image){
                    try{
                        $img_path = base_path() . '/uploads/products/source/';
                        $img_path200 = base_path() . '/uploads/products/resize200/';
                        $img_path800 = base_path() . '/uploads/products/resize800/';
                        if($image->server_name){
                            unlink(sprintf($img_path . '%s', $image->server_name));
                            unlink(sprintf($img_path200 . '%s', $image->server_name));
                            unlink(sprintf($img_path800 . '%s', $image->server_name));
                        }
                    }catch(Exception $e){
                    }
                }
                DB::table('temp_upload_files')->where('product_id',$id)->delete();
                session()->forget('imagesUpload');
                session()->forget('imagesUploadRealName');
            }
            return view('admin.products.editProduct',$data);
        }else{
            abort('404');
        }

    }

    public function changeCategory(Request $request,$id){
        $product=Product::find($id);
        $product->category_id = $request->category_id;
        $product->save();

        //////delete colors and color images////
        ProductColor::where('product_id',$id)->delete();
        ProductImage::where('product_id',$id)->delete();
        return back()->with('success',trans('home.category_changed_successfully'));
    }

    public function changeColors(Request $request,$id){
        ProductColor::where('product_id',$id)->delete();

        foreach($request->color_id as $colorId){
            $productColor = new ProductColor();
            $productColor->color_id = $colorId;
            $productColor->product_id = $id;
            $productColor->save();
        }

        return back()->with('success',trans('home.colors_changed_successfully'));
    }

    public function update(Request $request, $id){

        $add = Product::find($id);
        $add->name_en = $request->name_en;
        $add->name_ar = $request->name_ar;
        $add->link_en = str_replace(" ","-",$request->link_en??$request->name_en);
        $add->link_ar = str_replace(" ","-",$request->link_ar??$request->name_ar);
        $add->short_desc_en = $request->short_desc_en;
        $add->short_desc_ar = $request->short_desc_ar;
        $add->long_desc_en = $request->long_desc_en;
        $add->long_desc_ar = $request->long_desc_ar;
        $add->char_desc_ar = $request->char_desc_ar;
        $add->char_desc_en = $request->char_desc_en;
        $add->brand_id = $request->brand_id;
        $add->category_id = $request->category_id;

        $add->sku_code = $request->sku_code;
        $add->ean = $request->ean;
        $add->weight = $request->weight;
        $add->tall = $request->tall;
        $add->width =$request->width;
        $add->rate = $request->rate;
        $add->height  = $request->height;
        $add->status = $request->status;
        $add->featurd =$request->featurd;
        $add->home  = $request->home;
        $add->meta_title_en = $request->meta_title_en;
        $add->meta_desc_en = $request->meta_desc_en;
        $add->meta_title_ar = $request->meta_title_ar;
        $add->meta_desc_ar = $request->meta_desc_ar;
        $add->meta_robots = $request->meta_robots ;
        $add->price =$request->price;
        $add->shipping_fees  = $request->shipping_fees;
        $add->stock = $request->stock;
        $add->save();
        /////////// save product discount////////////
        if($request->value && $request->start_date && $request->end_date){
            ProductDiscount::where('product_id',$id)->delete();
            $price=new ProductDiscount();
            $price->product_id =$add->id;
            $price->value_type=$request->value_type;
            $price->value=$request->value;
            $price->start_date=$request->start_date;
            $price->end_date=$request->end_date;
            $price->save();
        }else{
            ProductDiscount::where('product_id',$id)->delete();
        }


        return redirect('/admin/products')->with('success',trans('home.product_data_updated_successfully'));
    }

    public function destroy($ids){
        //
        $ids = explode(',', $ids);
        if ($ids[0] == 'on') {
            unset($ids[0]);
        }
        $products = Product::whereIn('id',$ids)->checkBeforDelete()->get();
        // dd($categories, $ids);
        if(count($products) > 0){
            if (request()->ajax()) {
                return response()->json(['message'=>__('home.the item cannot be deleted. There is data related to it')],402);
            }
            return redirect()->back()->withErrors(__('home.the item cannot be deleted. There is data related to it'));
        }
        $img_path = base_path() . '/uploads/products/source/';
        $img_path200 = base_path() . '/uploads/products/resize200/';
        $img_path800 = base_path() . '/uploads/products/resize800/';


        foreach ($ids as $id) {
            $product = Product::findOrFail($id);
            $images = ProductImage::where('product_id',$id)->get();
            if($images){
                foreach($images as $image){
                    if ($image != null) {
                        file_exists($img_path.$image->image)?unlink($img_path.$image->image):'';
                        file_exists($img_path200.$image->image)?unlink($img_path200.$image->image):'';
                        file_exists($img_path800.$image->image)?unlink($img_path800.$image->image):'';
                    }
                }
            }

            $product->delete();
        }
    }

    public function productCategoryAttributes(){
        $categoryId=$_POST['categoryId'];
        $attributeIds=CategoryAttribute::where('category_id',$categoryId)->pluck('attribute_id')->toArray();
        $attributes = Attribute::whereIn('id',$attributeIds)->get();
        return response()->json(['html' => view('admin.products.attributes', compact('attributes'))->render()]);
    }

        // public function deleteImege(){
        //     $productId = $_POST['productId'];
        //     $image = $_POST['image'];
        //     $img =ProductImage::where('product_id',$productId)->where('id',$image)->first();

        //     $img_path = base_path() . '/uploads/products/source/';
        //     $img_path200 = base_path() . '/uploads/products/resize200/';
        //     $img_path800 = base_path() . '/uploads/products/resize800/';

        //     if ($img->image != null) {
        //         unlink(sprintf($img_path . '%s', $img->image));
        //         unlink(sprintf($img_path200 . '%s', $img->image));
        //         unlink(sprintf($img_path800 . '%s', $img->image));
        //     }
        //     $img->delete();
        // }

        // /////// upload product images///////////////
        // public function uploadImages(Request $request){

        //     if($request->hasFile('file')){

        //         $file = $request->file("file");
        //         $realName = $file->getClientOriginalName();
        //         $mime = File::mimeType($file);
        //         $mimearr = explode('/', $mime);

        //         // $destinationPath = base_path() . '/uploads/'; // upload path
        //         $extension = $mimearr[1]; // getting file extension
        //         $fileName = rand(11111111, 99999999) . '.' . $extension; // renameing image

        //         $path = base_path('uploads/products/source/' . $fileName);
        //         $resize200 = base_path('uploads/products/resize200/' . $fileName);
        //         $resize800 = base_path('uploads/products/resize800/' . $fileName);

        //         //  $file->move($destinationPath, $fileName);

        //         Image::make($file->getRealPath())->save($path);

        //         $arrayimage = list($width, $height) = getimagesize($file->getRealPath());
        //         $widthreal = $arrayimage['0'];
        //         $heightreal = $arrayimage['1'];

        //         $width200 = ($widthreal / $heightreal) * 150;
        //         $height200 = $width200 / ($widthreal / $heightreal);

        //         $img200 = Image::canvas($width200, $height200);
        //         $image200 = Image::make($file->getRealPath())->resize($width200, $height200, function ($c) {
        //             $c->aspectRatio();
        //             $c->upsize();
        //         });
        //         $img200->insert($image200, 'center');
        //         $img200->save($resize200);

        //         $width800 = ($widthreal / $heightreal) * 800;
        //         $height800 = $width800 / ($widthreal / $heightreal);

        //         $img800 = Image::canvas($width800, $height800);
        //         $image800 = Image::make($file->getRealPath())->resize($width800, $height800, function ($c) {
        //             $c->aspectRatio();
        //             $c->upsize();
        //         });
        //         $img800->insert($image800, 'center');
        //         $img800->save($resize800);
        //         DB::table('temp_upload_files')->insert(['server_name' => $fileName,'original_name' => $realName,'type' => $request->type ,'product_id' => $request->productId ,'color_id' => $request->colorId]);
        //         if(\Session::has('imagesUpload')){
        //             \Session::push('imagesUpload',$fileName);
        //             \Session::push('imagesUploadRealName',$realName);
        //             \Session::push('imagesUploadColorId',$request->colorId);
        //         }else{
        //             $images = [];
        //             array_push($images,$fileName);
        //             \Session::put('imagesUpload',$images);

        //             $realImages = [];
        //             array_push($realImages,$realName);
        //             \Session::put('imagesUploadRealName',$realImages);

        //             $imagesColors = [];
        //             array_push($imagesColors,$request->colorId);
        //             \Session::put('imagesUploadColorId',$imagesColors);
        //         }
        //     }

        // }

        ///////// delete uploaded images///////////
    public function removeUploadImages(Request $request)
    {
        $name = $request->name;
        $names = \Session::get('imagesUploadRealName');
        $images = \Session::get('imagesUpload');
        $key = array_search($name, $names);

        $img_path = base_path() . '/uploads/products/source/';
        $img_path200 = base_path() . '/uploads/products/resize200/';
        $img_path800 = base_path() . '/uploads/products/resize800/';

        unlink(sprintf($img_path . '%s', $images[$key]));
        unlink(sprintf($img_path200 . '%s', $images[$key]));
        unlink(sprintf($img_path800 . '%s', $images[$key]));

        unset($images[$key]);
        unset($names[$key]);
        \Session::put('imagesUpload',$images);
        \Session::put('imagesUploadRealName',$names);
        DB::table('temp_upload_files')->where('original_name',$name)->delete();
    }

    ////////// store data from excel sheet ///////
    public function updatePriceList(Request $request){

        $this->validate($request,[
            'excel' => 'required|mimes:xlsx'
        ]);

        try{
             Excel::import(new ProductPriceListImport, $request->excel);
             return back()->with('success','price list updated successfully');
        } catch (\Exception $ex) {
            return back()->withError('some thing wrong');
        }
    }

    public function removeProductAttributeValue( $id){
        try {
            $lang = LaravelLocalization::getCurrentLocale();
            App::setlocale($lang);
             $product_attri = ProductAttribute::find($id);
             $product_id = $product_attri->product_id ;
             $product_attri->delete();
             $html_stock = $this->editGroups($product_id);
            return response()->json(['status'=>true,'html_stock'=>$html_stock]);
        } catch (\Exception $ex) {
            if(request()->ajax()){
                return response()->json(['status'=>false,'message'=>$ex->getMessage()]);
            }
            if(env('APP_DEBUG')){
                dd($ex->getMessage());
            }

            return abort(500,__('home.an error occurred please connect with developer to solve it'));
        }

    }

    public function addProductAttributeValue(){
        try {
            $lang = LaravelLocalization::getCurrentLocale();
            App::setlocale($lang);
            $productAttributeValue = new ProductAttribute();
            $productAttributeValue->product_id = request()->input('product_id');
            $productAttributeValue->attribute_id = request()->input('attr_id');
            $productAttributeValue->attribute_value_id = request()->input('val_id');
            $productAttributeValue->save();
            $attribute = Attribute::find(request()->input('attr_id'));
            $isNewAttr = ProductAttribute::where('product_id', request()->input('product_id'))->where('attribute_id',request()->input('attr_id'))->count();
            if($isNewAttr > 1){
                $html = view('admin.products.append_val_to_attr',['attribute'=>$attribute,'product_id'=>request()->input('product_id')])->render();
                $id  = $attribute->{'name_'.$lang}.$attribute->id ;
            }elseif ($isNewAttr ==1) {
                $html = view('admin.products.append_attr_with_val',['attribute'=>$attribute,'product_id'=> request()->input('product_id')])->render();
                $id  = "append-attributes" ;
            }else {
                $html = '';
                $id = '';
            }
            $html_stock = $this->editGroups( $productAttributeValue->product_id);
            return response()->json(['status'=>true,'html'=>$html,'id'=> $id,'html_stock'=>$html_stock ]);
        } catch (\Exception $ex) {
            if(request()->ajax()){
                return response()->json(['status'=>false,'message'=>$ex->getMessage()]);
            }
            if(env('APP_DEBUG')){
                dd($ex->getMessage());
            }

            return abort(500,__('home.an error occurred please connect with developer to solve it'));
        }

    }

    public function getDoesntHaveAttr($id)
    {
        try {
            $lang = LaravelLocalization::getCurrentLocale();
            App::setlocale($lang);
            $data['attrs'] = Attribute::whereNotIn('id',ProductAttribute::where('product_id',$id)->distinct()->get('attribute_id')->pluck('attribute_id'))->get();
            $html = view('admin.products.append_attr_to_modal',$data)->render();
            return response()->json(['status'=>true,'html'=>$html]);
        } catch (\Exception $ex) {
            if(request()->ajax()){
                return response()->json(['status'=>false,'message'=>$ex->getMessage()]);
            }
            if(env('APP_DEBUG')){
                dd($ex->getMessage());
            }

            return abort(500,__('home.an error occurred please connect with developer to solve it'));
        }

    }

    public function getDoesntHaveVal()
    {
        try {
            $lang = LaravelLocalization::getCurrentLocale();
            App::setlocale($lang);
            $product_id = request()->input('product_id');
            $attribute_id =  request()->input('attr_id');
            $productValids =ProductAttribute::where('attribute_id',$attribute_id)->where('product_id',$product_id)->distinct()->get('attribute_value_id')->pluck('attribute_value_id');
            $data['vals'] = AttributeValue::where('attribute_id',$attribute_id)->whereNotIn('id',$productValids)->with('attribute')->get();
            $html = view('admin.products.append_val_to_modal',$data)->render();
            return response()->json(['status'=>true,'html'=>$html]);
        } catch (\Exception $ex) {
            if(request()->ajax()){
                return response()->json(['status'=>false,'message'=>$ex->getMessage()]);
            }
            if(env('APP_DEBUG')){
                dd($ex->getMessage());
            }

            return abort(500,__('home.an error occurred please connect with developer to solve it'));
        }

    }

    public function saveToImages($product_id)
    {
        try {
            $lang = LaravelLocalization::getCurrentLocale();
            App::setlocale($lang);
            $saveImage = new SaveImageTo3Path(request()->file('image'),true);
            $fileName = $saveImage->saveImages('products');
            $image = new ProductImage();
            $image->image = $fileName ;
            $image->product_id = $product_id ;
            $image->save();
            $html_stock = $this->editGroups( $product_id);
            return response()->json(['status'=>true,'image' => $image,'html_stock'=>$html_stock]);
        } catch (\Exception $ex) {
            if(request()->ajax()){
                return response()->json(['status'=>false,'message'=>$ex->getMessage()]);
            }
            if(env('APP_DEBUG')){
                dd($ex->getMessage());
            }

            return abort(500,__('home.an error occurred please connect with developer to solve it'));
        }

    }
    public function deleteFromImages($image_id)
    {
        try {
            $lang = LaravelLocalization::getCurrentLocale();
            App::setlocale($lang);
            $image = ProductImage::find($image_id);
            SaveImageTo3Path::deleteImage($image->image,'products');
            $product_id = $image->product_id ;
            $image->delete();
            $html_stock = $this->editGroups( $product_id);
            return response()->json(['status'=>true,'html_stock'=>$html_stock]);
        } catch (\Exception $ex) {
            if(request()->ajax()){
                return response()->json(['status'=>false,'message'=>$ex->getMessage()]);
            }
            if(env('APP_DEBUG')){
                dd($ex->getMessage());
            }

            return abort(500,__('home.an error occurred please connect with developer to solve it'));
        }

    }

    // public function addPriceToValue(){
    //     $lang = LaravelLocalization::getCurrentLocale();
    //     App::setlocale($lang);
    //     if(request()->has(['pro_attr_id','price'])){
    //         $proAttr_id = request('pro_attr_id');
    //         $price = request('price');
    //         ProductAttribute::find($proAttr_id)->update(['price'=>$price]);
    //         return response()->json(['status'=>true,'message'=> __("home.the price has been changed successfully")]);
    //     }
    //     return response()->json(['status'=>false,'message'=> __('home.an error accorred')]);
    // }


    public function newGroupForStockAndPrice($product_id){
        try {
            $lang = LaravelLocalization::getCurrentLocale();
            App::setlocale($lang);
            $stock = Stock::create(['product_id'=>$product_id]);
            $data['stock'] = Stock::find( $stock->id);
            $data['imagesStoc'] = ProductImage::where('product_id',$product_id)->get();
            $html = view('admin.products.add_new_group',$data)->render();
            return response()->json(['status'=>true,'message'=> __('home.Success'),'data'=>$data['stock'],'html'=> $html]);
            } catch (\Exception $ex) {
            if(request()->ajax()){
                return response()->json(['status'=>false,'message'=>$ex->getMessage()]);
            }
            if(env('APP_DEBUG')){
                dd($ex->getMessage(),$ex->getFile(),$ex->getLine());
            }

            return abort(500,__('home.an error occurred please connect with developer to solve it'));
        }

    }

    public function addToStock($stock_id){
        try {
            $lang = LaravelLocalization::getCurrentLocale();
            App::setlocale($lang);
            if(request()->has('image')){
                $stock = $this->updateImageInStock($stock_id);
                return response()->json(['status' => true, 'message' => __('home.your_item_updated_successfully'),'data' => $stock]);
            }elseif (request()->has('price')) {
                $stock = $this->updatePriceInStock($stock_id);
                return response()->json(['status' => true, 'message' => __('home.your_item_updated_successfully'),'data' => $stock]);
            }elseif (request()->has('stock')) {
                $stock = $this->updateStockInStock($stock_id);
                return response()->json(['status' => true, 'message' => __('home.your_item_updated_successfully'),'data' => $stock]);
            }elseif (request()->has('product_attribute_id')) {
                $html = $this->updateProductAttributeIdInStock($stock_id);
                return response()->json(['status' => true, 'message' => __('home.your_item_updated_successfully'),'html' => $html]);
            }else{
                return response()->json(['status' => false, 'message' => __('home.an error occurred')]);
            }
        } catch (\Exception $ex) {
            if(request()->ajax()){
                return response()->json(['status'=>false,'message'=>$ex->getMessage()]);
            }
            if(env('APP_DEBUG')){
                dd($ex->getMessage());
            }

            return abort(500,__('home.an error occurred please connect with developer to solve it'));
        }

    }
    public function removeValueFromStock(){
        try {
            $lang = LaravelLocalization::getCurrentLocale();
            App::setlocale($lang);
            $stock = Stock::find(request('stock_id'));
            $product_attribute_ids = array_diff($stock->product_attribute_id,[request('product_attribute_id')]) ;
            $stock->update(['product_attribute_id'=>$product_attribute_ids]);
            $stock = Stock::find(request('stock_id'));
            if(count($stock->product_attribute_id)){
                $html = $this->getAvilableAndGroupValues($stock);
                $html_stock = $this->editGroups($stock->product_id);
            }else{
                $html ='';
                $html_stock = '';
                $stock->delete();
            }

            return response()->json(['status'=>true,'message'=> __('home.Success'),'data'=>null,'html'=> $html,'html_stock'=>$html_stock]);

        } catch (\Exception $ex) {
            if(request()->ajax()){
                return response()->json(['status'=>false,'message'=>$ex->getMessage()]);
            }
            if(env('APP_DEBUG')){
                dd($ex->getMessage());
            }

            return abort(500,__('home.an error occurred please connect with developer to solve it'));
        }
          }

    private function getAvilableAndGroupValues(Stock $stock){
        $avilable_values = $stock->avilable_values_for_group;
        $group_values = $stock->product_groups;
        $html['avilable_values'] = view('admin.products.add_new_group',['avilable_values'=>$avilable_values,'stock_id'=>$stock->id])->render();
        $html['group_values'] = view('admin.products.add_new_group',['group_values'=>$group_values,'stock_id'=>$stock->id])->render();
        return $html ;
    }

    private function updateProductAttributeIdInStock($stock_id)
    {
        $stock = Stock::findOrFail($stock_id);
        $product_attribute_id = request('product_attribute_id');
        $productAttribute = ProductAttribute::findOrFail($product_attribute_id);
        $allValuesInAttribute = ProductAttribute::where('attribute_id', $productAttribute->attribute_id)
                                                ->pluck('attribute_value_id')
                                                ->toArray();
        $product_attribute_ids = $stock->product_attribute_id;

        if (!count(array_intersect($allValuesInAttribute, $product_attribute_ids))) {
            $product_attribute_ids[] = $product_attribute_id;
            $stock->product_attribute_id = $product_attribute_ids;
            $stock->save();
            return  $this->getAvilableAndGroupValues(Stock::findOrFail($stock_id));
        }
        return  Stock::findOrFail($stock_id);
    }

    private function updatePriceInStock($stock_id)
    {
        // Fetch the stock item or throw a 404 if not found
        $stock = Stock::findOrFail($stock_id);
        $stock->update(['price'=> request('price')]);
        return  Stock::findOrFail($stock_id);
    }
    private function updateStockInStock($stock_id)
    {
        $stock = Stock::findOrFail($stock_id);
        $stock->update(['stock'=> request('stock')]);
        return  Stock::findOrFail($stock_id);
    }

    private function updateImageInStock($stock_id)
    {
        $stock = Stock::findOrFail($stock_id);
        $stock->update(['image_id'=> request('image')]);
        return  Stock::findOrFail($stock_id);
    }

    private function editGroups($product_id){
        $stocks = Stock::where('product_id',$product_id)->get();
        $data['html_stock'] = "" ;
        $images = ProductImage::where('product_id',$product_id)->get();
        foreach ($stocks as  $value ) {
            $value->clean;
            $data['html_stock'] .= view('admin.products.add_new_group',['stock'=>$value,'imagesStoc'=> $images])->render();
        }
        return  $data['html_stock'] ;
    }

}
