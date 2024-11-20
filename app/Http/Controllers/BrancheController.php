<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Branche;
use DB;
use File;
use Image;
use App\Models\Region;
use App\Models\Area;

class BrancheController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:branches');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $branches = Branche::get();
        return view('admin.branches.branches',compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regions=Region::where('status',1)->get();
        return view('admin.branches.addBranche',compact('regions'));
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
        $add = new Branche();
        $add->name_en = $request->name_en;
        $add->name_ar = $request->name_ar;
        $add->address_en = $request->address_en;
        $add->address_ar = $request->address_ar;
        $add->mobile = $request->mobile;
        $add->mobile2 = $request->mobile2;
        $add->telephone = $request->telephone;
        $add->map_url = $request->map_url;
        $add->region_id = $request->region_id;
        $add->area_id = $request->area_id;
        $add->status = $request->status;
        
        if ($request->hasFile("logo")) {

            $file = $request->file("logo");
            $mime = File::mimeType($file);
            $mimearr = explode('/', $mime);

            // $destinationPath = base_path() . '/uploads/'; // upload path
            $extension = $mimearr[1]; // getting file extension
            $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
            $path = base_path('uploads/branches/source/' . $fileName);
            $resize200 = base_path('uploads/branches/resize200/' . $fileName);
            $resize800 = base_path('uploads/branches/resize800/' . $fileName);
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

            $add->logo = $fileName;
        }
        $add->save();
        return redirect()->route('branches.index')->with('success',trans('home.your_item_updated_successfully'));
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
        $branche = Branche::find($id);
        if($branche){
            $regions=Region::where('status',1)->get();
            $areas=Area::where('region_id',$branche->region_id)->get();
            return view('admin.branches.editBranche',compact('branche','regions','areas'));
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
        $add = Branche::find($id);
        $add->name_en = $request->name_en;
        $add->name_ar = $request->name_ar;
        $add->address_en = $request->address_en;
        $add->address_ar = $request->address_ar;
        $add->mobile = $request->mobile;
        $add->mobile2 = $request->mobile2;
        $add->telephone = $request->telephone;
        $add->map_url = $request->map_url;
        $add->region_id = $request->region_id;
        $add->area_id = $request->area_id;
        $add->status = $request->status;
        
        if ($request->hasFile("logo")) {

            $file = $request->file("logo");
            $mime = File::mimeType($file);
            $mimearr = explode('/', $mime);

            $img_path = base_path() . '/uploads/branches/source/';
            $img_path200 = base_path() . '/uploads/branches/resize200/';
            $img_path800 = base_path() . '/uploads/branches/resize800/';

            if ($add->logo != null) {
                unlink(sprintf($img_path . '%s', $add->logo));
                unlink(sprintf($img_path200 . '%s', $add->logo));
                unlink(sprintf($img_path800 . '%s', $add->logo));
            }

            // $destinationPath = base_path() . '/uploads/'; // upload path
            $extension = $mimearr[1]; // getting file extension
            $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
            $path = base_path('uploads/branches/source/' . $fileName);
            $resize200 = base_path('uploads/branches/resize200/' . $fileName);
            $resize800 = base_path('uploads/branches/resize800/' . $fileName);
            //  $file->move($destinationPath, $fileName);

            $img =Image::make($file->getRealPath());
            $img->save($path);

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

            $add->logo = $fileName;
        }
        $add->save();
        return redirect()->route('branches.index')->with('success',trans('home.your_item_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    
    public function destroy($ids){
        //
        $ids = explode(',', $ids);
        if ($ids[0] == 'on') {
            unset($ids[0]);
        }
        $img_path = base_path() . '/uploads/branches/source/';
        $img_path200 = base_path() . '/uploads/branches/resize200/';
        $img_path800 = base_path() . '/uploads/branches/resize800/'; 
        
        foreach ($ids as $id) {
            $branche = Branche::findOrFail($id);

            if ($branche->logo != null) {
                unlink(sprintf($img_path . '%s', $branche->logo));
                unlink(sprintf($img_path200 . '%s', $branche->logo));
                unlink(sprintf($img_path800 . '%s', $branche->logo));
            }

            $branche->delete();
        }
    }
}
