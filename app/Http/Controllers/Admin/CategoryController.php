<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SaveImageTo3Path;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware(['permission:categories']);
    }

    public function index()
    {
        //
        $categories = Category::orderBy('id','DESC')->get();
        return view('admin.categories.categories',compact('categories'));
    }


    public function create()
    {
        $categories=Category::where('status',1)->get();
        return view('admin.categories.addCategory',compact('categories'));
    }


    public function store(CategoryRequest $request)
    {
        $data = $request->validated() ;

        if ($request->hasFile("image")) {
            $saveImage = new SaveImageTo3Path(request()->file('image'),true);
            $fileName = $saveImage->saveImages('categories');
            $data['image'] = $fileName ;
        }

        if ($request->hasFile("icon")) {
            $saveImage = new SaveImageTo3Path(request()->file('icon'),true);
            $fileName = $saveImage->saveImages('categories');
            $data['icon'] = $fileName ;
        }

        Category::create($data) ;

        return redirect()->back()->with('success',trans('home.your_item_added_successfully'));
    }


    public function edit($id)
    {
        $category = Category::find($id);
        if($category){
            $categories = Category::where('id','!=',$id)->where('status',1)->get();
            return view('admin.categories.editCategory',compact('categories','category'));
        }else{
            abort('404');
        }

    }


    public function update(CategoryRequest $request, $id)
    {
        $category = Category::find($id) ;
        $data = $request->validated() ;
        if ($request->hasFile("image")) {
            $saveImage = new SaveImageTo3Path(request()->file('image'),true);
            $fileName = $saveImage->saveImages('categories');
            SaveImageTo3Path::deleteImage($category->image,'categories');
            $data['image'] = $fileName;
        }

        if ($request->hasFile("icon")) {
            $saveImage = new SaveImageTo3Path(request()->file('icon'),true);
            $fileName = $saveImage->saveImages('categories');
            SaveImageTo3Path::deleteImage($category->icon,'categories');
            $data['icon'] = $fileName;
        }
        $category->update($data) ;

        return redirect()->back()->with('success',trans('home.your_item_updated_successfully'));
    }


    public function destroy($id)
    {

        if( request('id')){
            request()->validate([
                'id' => 'array|min:1|',
                'id.*' => 'exists:categories,id'
            ]);
            $ids =  request('id') ;
            $delete = Category::whereIn('id',$ids)->delete();
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
        }elseif($aboutStruc = Category::find($id)){
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
