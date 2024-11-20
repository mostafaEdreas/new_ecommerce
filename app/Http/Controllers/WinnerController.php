<?php

namespace App\Http\Controllers;

use App\Models\Winner;
use DB;
use File;
use Image;
use Illuminate\Http\Request;

class WinnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware(['permission:winners']);
    }

    public function index()
    {
        //
        $winners = Winner::orderBy('id','DESC')->get();
        return view('admin.winners.winners',compact('winners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.winners.addWinner');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $add = new Winner();
        $add->name = $request->name;
        $add->email = $request->email;
        $add->phone = $request->phone;
        $add->order = $request->order;
        $add->text = $request->text;
        $add->status = $request->status;
        if ($request->hasFile("image")) {

            $file = $request->file("image");
            $mime = File::mimeType($file);
            $mimearr = explode('/', $mime);

            // $destinationPath = base_path() . '/uploads/'; // upload path
            $extension = $mimearr[1]; // getting file extension
            $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
            $path = base_path('uploads/winners/source/' . $fileName);
            $resize200 = base_path('uploads/winners/resize200/' . $fileName);
            $resize800 = base_path('uploads/winners/resize800/' . $fileName);
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
        return redirect('admin/winners')->with('success',trans('home.your_item_added_successfully'));
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
        $winner=Winner::find($id);
        if($winner){
            return view('admin.winners.editWinner',compact('winner'));
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
        $add = Winner::find($id);
        $add->name = $request->name;
        $add->email = $request->email;
        $add->phone = $request->phone;
        $add->order = $request->order;
        $add->text = $request->text;
        $add->status = $request->status;
        if ($request->hasFile("image")) {

            $file = $request->file("image");
            $mime = File::mimeType($file);
            $mimearr = explode('/', $mime);

            $img_path = base_path() . '/uploads/winners/source/';
            $img_path200 = base_path() . '/uploads/winners/resize200/';
            $img_path800 = base_path() . '/uploads/winners/resize800/';

            if ($add->image != null) {
                unlink(sprintf($img_path . '%s', $add->image));
                unlink(sprintf($img_path200 . '%s', $add->image));
                unlink(sprintf($img_path800 . '%s', $add->image));
            }

            // $destinationPath = base_path() . '/uploads/'; // upload path
            $extension = $mimearr[1]; // getting file extension
            $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
            $path = base_path('uploads/winners/source/' . $fileName);
            $resize200 = base_path('uploads/winners/resize200/' . $fileName);
            $resize800 = base_path('uploads/winners/resize800/' . $fileName);
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

            $add->image = $fileName;
        }
        $add->save();
        return redirect('/admin/winners')->with('success',trans('home.your_item_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($ids)
    {
        //
        $ids = explode(',', $ids);
        if ($ids[0] == 'on') {
            unset($ids[0]);
        }
        $img_path = base_path() . '/uploads/winners/source/';
        $img_path200 = base_path() . '/uploads/winners/resize200/';
        $img_path800 = base_path() . '/uploads/winners/resize800/'; 
        
        foreach ($ids as $id) {
            $winner = Winner::findOrFail($id);

            if ($brand->logo != null) {
                unlink(sprintf($img_path . '%s', $winner->image));
                unlink(sprintf($img_path200 . '%s', $winner->image));
                unlink(sprintf($img_path800 . '%s', $winner->image));
            }

            $brand->delete();
        }
    }  
    
}
