<?php

namespace App\Http\Controllers;

use App\Helpers\SaveImageTo3Path;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\About;

use DB;
use File;
use Image;

class AboutController extends Controller
{

    public function __construct(){
        $this->middleware(['permission:about']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editAbout()
    {
        $about = About::first();
        return view('admin.about.editAbout',compact('about'));
    }

    public function update(Request $request)
    {
        $add = About::first();
        $add->title_en = $request->title_en;
        $add->text_en = $request->text_en;
        $add->title_ar = $request->title_ar;
        $add->text_ar = $request->text_ar;

        if ($request->hasFile("image")) {

            $saveImage = new SaveImageTo3Path(request()->file('image'),true);
            $fileName = $saveImage->saveImages('aboutStrucs');
            SaveImageTo3Path::deleteImage($add->image,'aboutStrucs');
        //     $file = $request->file("image");
        //     $mime = File::mimeType($file);
        //     $mimearr = explode('/', $mime);

        //     $img_path = base_path() . '/uploads/aboutStrucs/source/';
        //     $img_path200 = base_path() . '/uploads/aboutStrucs/resize200/';
        //     $img_path800 = base_path() . '/uploads/aboutStrucs/resize800/';
        //     if ($add->image != null) {
        //         unlink(sprintf($img_path . '%s', $add->image));
        //         unlink(sprintf($img_path200 . '%s', $add->image));
        //         unlink(sprintf($img_path800 . '%s', $add->image));
        //     }
        //    // $destinationPath = base_path() . '/uploads/'; // upload path
        //     $extension = $mimearr[1]; // getting file extension
        //     $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
        //     $path = base_path('uploads/aboutStrucs/source/' . $fileName);
        //     $resize200 = base_path('uploads/aboutStrucs/resize200/' . $fileName);
        //     $resize800 = base_path('uploads/aboutStrucs/resize800/' . $fileName);
        //       //  $file->move($destinationPath, $fileName);

        //     Image::make($file->getRealPath())->save($path);

        //     $arrayimage = list($width, $height) = getimagesize($file->getRealPath());
        //     $widthreal = $arrayimage['0'];
        //     $heightreal = $arrayimage['1'];

        //     $width200 = ($widthreal / $heightreal) * 150;
        //     $height200 = $width200 / ($widthreal / $heightreal);

        //     $img200 = Image::canvas($width200, $height200);
        //     $image200 = Image::make($file->getRealPath())->resize($width200, $height200, function ($c) {
        //         $c->aspectRatio();
        //         $c->upsize();
        //     });
        //     $img200->insert($image200, 'center');
        //     $img200->save($resize200);

        //     $width800 = ($widthreal / $heightreal) * 800;
        //     $height800 = $width800 / ($widthreal / $heightreal);

        //     $img800 = Image::canvas($width800, $height800);
        //     $image800 = Image::make($file->getRealPath())->resize($width800, $height800, function ($c) {
        //         $c->aspectRatio();
        //         $c->upsize();
        //     });
        //     $img800->insert($image800, 'center');
        //     $img800->save($resize800);

            $add->image = $fileName;
        }
        if ($request->hasFile("banner")) {

            $saveImage = new SaveImageTo3Path(request()->file('banner'),true);
            $fileName = $saveImage->saveImages('aboutStrucs');
            SaveImageTo3Path::deleteImage($add->banner,'aboutStrucs');


        //     $file = $request->file("banner");
        //     $mime = File::mimeType($file);
        //     $mimearr = explode('/', $mime);

        //     $img_path = base_path() . '/uploads/aboutStrucs/source/';
        //     if ($add->image != null) {
        //         unlink(sprintf($img_path . '%s', $add->image));
        //     }
        //    // $destinationPath = base_path() . '/uploads/'; // upload path
        //     $extension = $mimearr[1]; // getting file extension
        //     $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
        //     $path = base_path('uploads/aboutStrucs/source/' . $fileName);
        //       //  $file->move($destinationPath, $fileName);

        //     Image::make($file->getRealPath())->save($path);
            $add->banner = $fileName;
        }
        $add->save();
        return redirect()->back()->with('success',trans('home.about_info_updated_successfully'));
    }
}
