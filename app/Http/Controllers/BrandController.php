<?php

namespace App\Http\Controllers;

use App\Helpers\SaveImageTo3Path;
use App\Http\Requests\BrandsRequest;
use App\Models\Brand;
use DB;
use File;
use Image;
use Illuminate\Http\Request;

class BrandController extends Controller
{


    public function __construct(){
        $this->middleware(['permission:brands']);
    }

    public function index()
    {
        $data['brands'] = Brand::all();

        return view('admin.brands.brands',$data);
    }


    public function create()
    {
        return view('admin.brands.addBrand');
    }


    public function store(BrandsRequest $request)
    {
        $data = $request->validated() ;

        if ($request->hasFile("image")) {
            $saveImage = new SaveImageTo3Path(request()->file('image'),true);
            $fileName = $saveImage->saveImages('brands');
            $data['image'] = $fileName ;
        }

        if ($request->hasFile("icon")) {
            $saveImage = new SaveImageTo3Path(request()->file('icon'),true);
            $fileName = $saveImage->saveImages('brands');
            $data['icon'] = $fileName ;
        }

        Brand::create($data) ;

        return redirect()->bsck()->with('success',trans('home.your_item_added_successfully'));
    }


    public function edit($id)
    {
        $brand=Brand::find($id);
        if($brand){
            return view('admin.brands.editBrand',compact('brand'));
        }else{
            abort('404');
        }
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::find($id) ;
        $data = $request->validated() ;
        if ($request->hasFile("image")) {
            $saveImage = new SaveImageTo3Path(request()->file('image'),true);
            $fileName = $saveImage->saveImages('brands');
            SaveImageTo3Path::deleteImage($brand->image,'brands');
            $data['image'] = $fileName;
        }

        if ($request->hasFile("icon")) {
            $saveImage = new SaveImageTo3Path(request()->file('icon'),true);
            $fileName = $saveImage->saveImages('brands');
            SaveImageTo3Path::deleteImage($brand->icon,'brands');
            $data['icon'] = $fileName;
        }
        $brand->update($data) ;

        return redirect()->back()->with('success',trans('home.your_item_updated_successfully'));
    }

    public function destroy($id)
    {
        if( request('id')){
            request()->validate([
                'id' => 'array|min:1|',
                'id.*' => 'exists:brands,id'
            ]);
            $ids =  request('id') ;
            $delete = Brand::whereIn('id',$ids)->delete();
            // check if comming from ajax
            if(request()->ajax()){
                // check is is deleted or has any exception
                if( !$delete ){
                    return response()->json(['message'=> $delete??__('home.an messages.error entering data')],422);
                }
                return response()->json(['message'=>trans('home.your_items_deleted_successfully')]);
            }
            if( !$delete ){
                return redirect()->back()->withErrors( $delete??__('home.an messages.error entering data'));
            }
            return redirect()->back()->with('success',trans('home.your_items_deleted_successfully'));
        }elseif($aboutStruc = Brand::find($id)){
               // check is is deleted or has any exception
               $delete = $aboutStruc->delete();
            if(request()->ajax()){
                // check is is deleted or has any exception
                if( !$delete ){
                    return response()->json(['message'=> $delete??__('home.an message.error entering data')],422);
                }
                return response()->json(['message'=>trans('home.your_item_deleted_successfully')]);
            }
            if( !$delete ){
                return redirect()->back()->withErrors( $delete??__('home.an messages.error entering data'));
            }
            return redirect()->back()->with('success',trans('home.your_item_deleted_successfully'));
        }
    }

}
