<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Category;
use DB;
use File;
use Image;
use App\Models\CategoryColor;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware(['permission:colors']);
    }

    public function index()
    {
        //
        $colors = Color::orderBy('id','DESC')->get();
        return view('admin.colors.colors',compact('colors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::get();
        $colors=Color::get();
        return view('admin.colors.addColor',compact('categories','colors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $add = new Color();
        $add->name_en = $request->name_en;
        $add->name_ar = $request->name_ar;
        $add->hex_code = $request->hex_code;
        $add->status = $request->status;
        $add->parent_id = $request->parent_id;
        if ($request->hasFile("image")) {

            $file = $request->file("image");
            $mime = File::mimeType($file);
            $mimearr = explode('/', $mime);

            // $destinationPath = base_path() . '/uploads/'; // upload path
            $extension = $mimearr[1]; // getting file extension
            $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
            $path = base_path('uploads/colors/source/' . $fileName);
            $resize200 = base_path('uploads/colors/resize200/' . $fileName);
            $resize800 = base_path('uploads/colors/resize800/' . $fileName);
            //  $file->move($destinationPath, $fileName);

            Image::make($file->getRealPath())->save($path);

            $arrayimage = list($width, $height) = getimagesize($file->getRealPath());
            $widthreal = $arrayimage['0'];
            $heightreal = $arrayimage['1'];

            $width200 = ($widthreal / $heightreal) * 150;
            $height200 = $width200 / ($widthreal / $heightreal);

            $img200 = Image::canvas($width200, $height200);
            $image200 = Image::make($file->getRealPath())->resize($width200, $height200, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });
            $img200->insert($image200, 'center');
            $img200->save($resize200);

            $width800 = ($widthreal / $heightreal) * 800;
            $height800 = $width800 / ($widthreal / $heightreal);

            $img800 = Image::canvas($width800, $height800);
            $image800 = Image::make($file->getRealPath())->resize($width800, $height800, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });
            $img800->insert($image800, 'center');
            $img800->save($resize800);

            $add->image = $fileName;
        }
        $add->save();
        
        ////////// add color categories////////////
        if($request->category_id){
            $categoryIds=$request->category_id;
            foreach ($categoryIds as $categoryId){
                $check = CategoryColor::where('category_id',$categoryId)->where('color_id',$add->id)->first();
                if(!$check){
                    $categoryColor=new CategoryColor();
                    $categoryColor->category_id=$categoryId;
                    $categoryColor->color_id=$add->id;
                    $categoryColor->save();
                }
            }
        }
        return redirect('admin/colors')->with('success',trans('home.your_item_added_successfully'));
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
        $color=Color::find($id);
        if($color){
            $categories = Category::get();
            $colors=Color::get();
            $categories_ids = CategoryColor::where('color_id', $color->id)->pluck('category_id');
            return view('admin.colors.editColor',compact('color','categories','categories_ids','colors'));
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
    public function update(Request $request, $id)
    {
        $add = Color::find($id);
        $add->name_en = $request->name_en;
        $add->name_ar = $request->name_ar;
        $add->hex_code = $request->hex_code;
        $add->parent_id = $request->parent_id;
        $add->status = $request->status;
        if ($request->hasFile("image")) {

            $file = $request->file("image");
            $mime = File::mimeType($file);
            $mimearr = explode('/', $mime);

            $img_path = base_path() . '/uploads/colors/source/';
            $img_path200 = base_path() . '/uploads/colors/resize200/';
            $img_path800 = base_path() . '/uploads/colors/resize800/';
            if ($add->icon != null) {
                unlink(sprintf($img_path . '%s', $add->image));
                unlink(sprintf($img_path200 . '%s', $add->image));
                unlink(sprintf($img_path800 . '%s', $add->image));
            }

            // $destinationPath = base_path() . '/uploads/'; // upload path
            $extension = $mimearr[1]; // getting file extension
            $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
            $path = base_path('uploads/colors/source/' . $fileName);
            $resize200 = base_path('uploads/colors/resize200/' . $fileName);
            $resize800 = base_path('uploads/colors/resize800/' . $fileName);
            //  $file->move($destinationPath, $fileName);

            Image::make($file->getRealPath())->save($path);

            $arrayimage = list($width, $height) = getimagesize($file->getRealPath());
            $widthreal = $arrayimage['0'];
            $heightreal = $arrayimage['1'];

            $width200 = ($widthreal / $heightreal) * 150;
            $height200 = $width200 / ($widthreal / $heightreal);

            $img200 = Image::canvas($width200, $height200);
            $image200 = Image::make($file->getRealPath())->resize($width200, $height200, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });
            $img200->insert($image200, 'center');
            $img200->save($resize200);

            $width800 = ($widthreal / $heightreal) * 800;
            $height800 = $width800 / ($widthreal / $heightreal);

            $img800 = Image::canvas($width800, $height800);
            $image800 = Image::make($file->getRealPath())->resize($width800, $height800, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });
            $img800->insert($image800, 'center');
            $img800->save($resize800);

            $add->image = $fileName;
        }
        $add->save();
        
        ////////// add color categories////////////
        if($request->category_id){
            CategoryColor::where('color_id',$add->id)->delete();
            $categoryIds=$request->category_id;
            foreach ($categoryIds as $categoryId){
                $check = CategoryColor::where('category_id',$categoryId)->where('color_id',$add->id)->first();
                if(!$check){
                    $categoryColor=new CategoryColor();
                    $categoryColor->category_id=$categoryId;
                    $categoryColor->color_id=$add->id;
                    $categoryColor->save();
                }
            }
        }
        return redirect('/admin/colors')->with('success',trans('home.your_item_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($ids)
    {
        $ids = explode(',', $ids);
        if ($ids[0] == 'on') {
            unset($ids[0]);
        }
        $img_path = base_path() . '/uploads/colors/source/';
        $img_path200 = base_path() . '/uploads/colors/resize200/';
        $img_path800 = base_path() . '/uploads/colors/resize800/';
        foreach ($ids as $id) {
            $color = Color::findOrFail($id);
            if ($color->image != null) {
                unlink(sprintf($img_path . '%s', $color->image));
                unlink(sprintf($img_path200 . '%s', $color->image));
                unlink(sprintf($img_path800 . '%s', $color->image));
            }
            $color->delete();
        }
    }
}
