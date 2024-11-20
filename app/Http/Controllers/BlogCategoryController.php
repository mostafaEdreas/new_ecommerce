<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use DB;
use File;
use Illuminate\Support\Facades\Input;
use Image;

class BlogCategoryController extends Controller
{


    public function __construct()
    {
        $this->middleware('permission:blog-categories');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogCategories= BlogCategory::orderBy('id','desc')->get();
        return view('admin.blogCategories.blogCategories',compact('blogCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.blogCategories.addBlogCategory');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $blogcategory = new BlogCategory();
        $blogcategory->title_en = $request->title_en;
        $blogcategory->title_ar = $request->title_ar;
        $link_en = str_replace(" ","-",$blogcategory->title_en);
        $blogcategory->link_en = str_replace("/","-",$link_en);
        $link_ar = str_replace(" ","-",$blogcategory->title_ar);
        $blogcategory->link_ar = str_replace("/","-",$link_ar);
        $blogcategory->text_en = $request->text_en;
        $blogcategory->text_ar = $request->text_ar;
        $blogcategory->status = $request->status;
        $blogcategory->meta_title_en = $request->meta_title_en;
        $blogcategory->meta_desc_en = $request->meta_desc_en;
        $blogcategory->meta_title_ar = $request->meta_title_ar;
        $blogcategory->meta_desc_ar = $request->meta_desc_ar;
        $blogcategory->meta_robots = $request->meta_robots ;
        if ($request->hasFile("image")) {

            $file = $request->file("image");
            $mime = File::mimeType($file);
            $mimearr = explode('/', $mime);

           // $destinationPath = base_path() . '/uploads/'; // upload path
            $extension = $mimearr[1]; // getting file extension
            $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
            $path = base_path('uploads/blogitems/source/' . $fileName);
              //  $file->move($destinationPath, $fileName);

            Image::make($file->getRealPath())->save($path);
            $blogcategory->image = $fileName;
        }
        $blogcategory->save();
        return redirect()->route('blog-categories.index',app()->getLocale())->with('success',trans('home.your_item_added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $blogCategory = BlogCategory::find($id);
        if($blogCategory){
            return view('admin.blogCategories.editBlogCategory',compact('blogCategory'));
        }else{
            abort('404');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        $blogcategory = BlogCategory::find($id);
        $blogcategory->title_en = $request->title_en;
        $blogcategory->title_ar = $request->title_ar;

        $link_en = str_replace(" ","-",$blogcategory->title_en);
        $blogcategory->link_en = str_replace("/","-",$link_en);
        $link_ar = str_replace(" ","-",$blogcategory->title_ar);
        $blogcategory->link_ar = str_replace("/","-",$link_ar);

        $blogcategory->text_en = $request->text_en;
        $blogcategory->text_ar = $request->text_ar;
        $blogcategory->status = $request->status;
        $blogcategory->meta_title_en = $request->meta_title_en;
        $blogcategory->meta_desc_en = $request->meta_desc_en;
        $blogcategory->meta_title_ar = $request->meta_title_ar;
        $blogcategory->meta_desc_ar = $request->meta_desc_ar;
        $blogcategory->meta_robots = $request->meta_robots ;
        if ($request->hasFile("image")) {

            $file = $request->file("image");
            $mime = File::mimeType($file);
            $mimearr = explode('/', $mime);

            $img_path = base_path() . '/uploads/blogitems/source/';
            $img_path200 = base_path() . '/uploads/blogitems/resize200/';
            $img_path800 = base_path() . '/uploads/blogitems/resize800/';

            if ($blogcategory->image != null) {
                unlink(sprintf($img_path . '%s', $blogcategory->image));
            }

            $extension = $mimearr[1]; // getting file extension
            $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
            $path = base_path('uploads/blogitems/source/' . $fileName);
            Image::make($file->getRealPath())->save($path);

            $blogcategory->image = $fileName;
        }

        $blogcategory->save();
        return redirect()->route('blog-categories.index')->with('success',trans('home.your_item_updated_successfully'));

    }


    public function destroy($ids)
    {
        //
        $ids = explode(',', $ids);
        if ($ids[0] == 'on') {
            unset($ids[0]);
        }
        $blogCate = BlogCategory::whereIn('id',$ids)->CheckBeforDelete()->get();
        if(count($blogCate) > 0){
            if (request()->ajax()) {
                return response()->json(['message'=>__('home.the item cannot be deleted. There is data related to it')],402);
            }
            return redirect()->back()->withErrors(__('home.the item cannot be deleted. There is data related to it'));
        }
        foreach ($ids as $id) {
            $m = BlogCategory::findOrFail($id);
            $m->delete();
        }
    }
}
