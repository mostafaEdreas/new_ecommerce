<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SaveImageTo3Path;
use App\Http\Controllers\Controller;
use App\Http\Requests\AboutStrucRequest;
use App\Models\AboutStruc;
use App\Models\Discount;

class DiscountController extends Controller
{

    public function __construct(){
        $this->middleware(['permission:products']);
    }
    public function index()
    {
        $data['discounts'] = Discount::latest()->get();
        return view('admin.products.discount.index',$data);
    }


    public function store(AboutStrucRequest $request)
    {

        $data  = $request->validated() ;
        if ($request->hasFile("image")) {

            $file = $request->file("image");
            $saveImage = new SaveImageTo3Path($file,true);
            $fileName = $saveImage->saveImages('aboutStrucs');
            $data['image'] = $fileName;
        }
        AboutStruc::create( $data);
        return redirect()->back()->with('success',trans('home.your_item_added_successfully'));
    }


    public function edit( $id)
    {
        $aboutStruc = AboutStruc::find($id);
        if($data['aboutStruc'] = $aboutStruc){
            return view('admin.aboutStrucs.editAboutStruc',$data);
        }
        return abort(404);
    }


    public function update(AboutStrucRequest $request, $id)
    {
       $aboutStruc = AboutStruc::find($id);


        if( $aboutStruc){
            $data  = $request->validated() ;
            if ($request->hasFile("image")) {
                $file = $request->file("image");
                $saveImage = new SaveImageTo3Path($file,true);
                $fileName = $saveImage->saveImages('aboutStrucs');
                SaveImageTo3Path::deleteImage(  $aboutStruc->image, 'aboutStrucs');
                $data['image'] = $fileName;
            }
            $aboutStruc->update( $data);
            return redirect()->back()->with('success',trans('home.your_item_updated_successfully'));
        }

        return abort(404);
    }


    public function destroy($id)
    {

        if( request('id')){
            $ids =  request('id') ;
            $ids = is_array(   $ids ) ?    $ids  : [ $ids ];
            AboutStruc::whereIn('id',$ids)->delete();
            if(request()->ajax()){
                return response()->json(['message'=>trans('home.your_items_deleted_successfully')]);
            }
            return redirect()->back()->with('success',trans('home.your_items_deleted_successfully'));
        }elseif($aboutStruc = AboutStruc::find($id)){
            $aboutStruc->delete();
            if(request()->ajax()){
                return response()->json(['message'=>trans('home.your_item_deleted_successfully')]);
            }
            return redirect()->back()->with('success',trans('home.your_item_deleted_successfully'));
        }
    }
}
