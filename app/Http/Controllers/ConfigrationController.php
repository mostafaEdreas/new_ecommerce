<?php

namespace App\Http\Controllers;

use App\Helpers\SaveImageTo3Path;
use Illuminate\Http\Request;
use App\Models\Configration;
use File;
use Image;
class ConfigrationController extends Controller
{
    public function __construct(){
        $this->middleware(['permission:configrations']);
    }

    public function show($lang)
    {
        //
        $configrations =Configration::where('lang',$lang)->first();
        return view('admin.configrations.configration',compact('configrations'));
    }


    public function update(Request $request, $lang)
    {
        $configration = Configration::where('lang',$lang)->first();
        $configration -> app_name = $request -> app_name;
        $configration -> about_app = $request -> about_app;
        $configration -> address1 = $request -> address1;
        $configration -> address2 = $request -> address2;
        $configration -> top_text = $request -> top_text;
        if ($request->hasFile("app_logo")) {

            $saveImage = new SaveImageTo3Path(request()->file('app_logo'),true);
            $fileName = $saveImage->saveImages('settings');
            SaveImageTo3Path::deleteImage($configration->app_logo,'settings');

            // $file = $request->file("app_logo");
            // $mime = File::mimeType($file);
            // $mimearr = explode('/', $mime);

            // $img_path = base_path() . '/uploads/settings/source/';
            // $img_path200 = base_path() . '/uploads/settings/resize200/';
            // $img_path800 = base_path() . '/uploads/settings/resize800/';

            // if ($configration->app_logo != null) {
            //     unlink(sprintf($img_path . '%s', $configration->app_logo));
            //     unlink(sprintf($img_path200 . '%s', $configration->app_logo));
            //     unlink(sprintf($img_path800 . '%s', $configration->app_logo));
            // }

            // // $destinationPath = base_path() . '/uploads/'; // upload path
            // $extension = $mimearr[1]; // getting file extension
            // $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
            // $path = base_path('uploads/settings/source/' . $fileName);
            // $resize200 = base_path('uploads/settings/resize200/' . $fileName);
            // $resize800 = base_path('uploads/settings/resize800/' . $fileName);
            // //  $file->move($destinationPath, $fileName);

            // Image::make($file->getRealPath())->save($path);

            // $arrayimage = list($width, $height) = getimagesize($file->getRealPath());
            // $widthreal = $arrayimage['0'];
            // $heightreal = $arrayimage['1'];
            // $width200 = ($widthreal / $heightreal) * 200;
            // $height200 = $width200 / ($widthreal / $heightreal);
            // $img200 = Image::canvas($width200, $height200);
            // $image200 = Image::make($file->getRealPath())->resize($width200, $height200, function ($c) {
            //     $c->aspectRatio();
            //     $c->upsize();
            // });
            // $img200->insert($image200, 'center');
            // $img200->save($resize200);

            // $width800 = ($widthreal / $heightreal) * 800;
            // $height800 = $width800 / ($widthreal / $heightreal);

            // $img800 = Image::canvas($width800, $height800);
            // $image800 = Image::make($file->getRealPath())->resize($width800, $height800, function ($c) {
            //     $c->aspectRatio();
            //     $c->upsize();
            // });
            // $img800->insert($image800, 'center');
            // $img800->save($resize800);

            $configration->app_logo = $fileName;
        }

        if ($request->hasFile("app_footer_logo")) {

            $saveImage = new SaveImageTo3Path(request()->file('app_footer_logo'),true);
            $fileName = $saveImage->saveImages('settings');
            SaveImageTo3Path::deleteImage($configration->app_footer_logo,'settings');
            // $file = $request->file("app_footer_logo");
            // $mime = File::mimeType($file);
            // $mimearr = explode('/', $mime);

            // $img_path = base_path() . '/uploads/settings/source/';
            // $img_path200 = base_path() . '/uploads/settings/resize200/';
            // $img_path800 = base_path() . '/uploads/settings/resize800/';

            // if ($configration->app_footer_logo != null) {
            //     unlink(sprintf($img_path . '%s', $configration->app_footer_logo));
            //     unlink(sprintf($img_path200 . '%s', $configration->app_footer_logo));
            //     unlink(sprintf($img_path800 . '%s', $configration->app_footer_logo));
            // }

            // // $destinationPath = base_path() . '/uploads/'; // upload path
            // $extension = $mimearr[1]; // getting file extension
            // $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
            // $path = base_path('uploads/settings/source/' . $fileName);
            // $resize200 = base_path('uploads/settings/resize200/' . $fileName);
            // $resize800 = base_path('uploads/settings/resize800/' . $fileName);
            // //  $file->move($destinationPath, $fileName);

            // Image::make($file->getRealPath())->save($path);

            // $arrayimage = list($width, $height) = getimagesize($file->getRealPath());
            // $widthreal = $arrayimage['0'];
            // $heightreal = $arrayimage['1'];
            // $width200 = ($widthreal / $heightreal) * 200;
            // $height200 = $width200 / ($widthreal / $heightreal);
            // $img200 = Image::canvas($width200, $height200);
            // $image200 = Image::make($file->getRealPath())->resize($width200, $height200, function ($c) {
            //     $c->aspectRatio();
            //     $c->upsize();
            // });
            // $img200->insert($image200, 'center');
            // $img200->save($resize200);

            // $width800 = ($widthreal / $heightreal) * 800;
            // $height800 = $width800 / ($widthreal / $heightreal);

            // $img800 = Image::canvas($width800, $height800);
            // $image800 = Image::make($file->getRealPath())->resize($width800, $height800, function ($c) {
            //     $c->aspectRatio();
            //     $c->upsize();
            // });
            // $img800->insert($image800, 'center');
            // $img800->save($resize800);

            $configration->app_footer_logo = $fileName;
        }

        if ($request->hasFile("about_image")) {
            $saveImage = new SaveImageTo3Path(request()->file('about_image'),true);
            $fileName = $saveImage->saveImages('settings');
            SaveImageTo3Path::deleteImage($configration->about_image,'settings');
            // $file = $request->file("about_image");
            // $mime = File::mimeType($file);
            // $mimearr = explode('/', $mime);

            // $img_path = base_path() . '/uploads/settings/source/';
            // $img_path200 = base_path() . '/uploads/settings/resize200/';
            // $img_path800 = base_path() . '/uploads/settings/resize800/';

            // if ($configration->about_image != null) {
            //     unlink(sprintf($img_path . '%s', $configration->about_image));
            //     unlink(sprintf($img_path200 . '%s', $configration->about_image));
            //     unlink(sprintf($img_path800 . '%s', $configration->about_image));
            // }

            // // $destinationPath = base_path() . '/uploads/'; // upload path
            // $extension = $mimearr[1]; // getting file extension
            // $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
            // $path = base_path('uploads/settings/source/' . $fileName);
            // $resize200 = base_path('uploads/settings/resize200/' . $fileName);
            // $resize800 = base_path('uploads/settings/resize800/' . $fileName);
            // //  $file->move($destinationPath, $fileName);

            // Image::make($file->getRealPath())->save($path);

            // $arrayimage = list($width, $height) = getimagesize($file->getRealPath());
            // $widthreal = $arrayimage['0'];
            // $heightreal = $arrayimage['1'];
            // $width200 = ($widthreal / $heightreal) * 200;
            // $height200 = $width200 / ($widthreal / $heightreal);
            // $img200 = Image::canvas($width200, $height200);
            // $image200 = Image::make($file->getRealPath())->resize($width200, $height200, function ($c) {
            //     $c->aspectRatio();
            //     $c->upsize();
            // });
            // $img200->insert($image200, 'center');
            // $img200->save($resize200);

            // $width800 = ($widthreal / $heightreal) * 800;
            // $height800 = $width800 / ($widthreal / $heightreal);

            // $img800 = Image::canvas($width800, $height800);
            // $image800 = Image::make($file->getRealPath())->resize($width800, $height800, function ($c) {
            //     $c->aspectRatio();
            //     $c->upsize();
            // });
            // $img800->insert($image800, 'center');
            // $img800->save($resize800);

            $configration->about_image = $fileName;
        }

        if ($request->hasFile("inspection_request_image")) {
            $saveImage = new SaveImageTo3Path(request()->file('inspection_request_image'),true);
            $fileName = $saveImage->saveImages('settings');
            SaveImageTo3Path::deleteImage($configration->inspection_request_image,'settings');
            // $file = $request->file("inspection_request_image");
            // $mime = File::mimeType($file);
            // $mimearr = explode('/', $mime);

            // $img_path = base_path() . '/uploads/settings/source/';
            // $img_path200 = base_path() . '/uploads/settings/resize200/';
            // $img_path800 = base_path() . '/uploads/settings/resize800/';

            // if ($configration->inspection_request_image != null) {
            //     unlink(sprintf($img_path . '%s', $configration->inspection_request_image));
            //     unlink(sprintf($img_path200 . '%s', $configration->inspection_request_image));
            //     unlink(sprintf($img_path800 . '%s', $configration->inspection_request_image));
            // }

            // // $destinationPath = base_path() . '/uploads/'; // upload path
            // $extension = $mimearr[1]; // getting file extension
            // $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
            // $path = base_path('uploads/settings/source/' . $fileName);
            // $resize200 = base_path('uploads/settings/resize200/' . $fileName);
            // $resize800 = base_path('uploads/settings/resize800/' . $fileName);
            // //  $file->move($destinationPath, $fileName);

            // Image::make($file->getRealPath())->save($path);

            // $arrayimage = list($width, $height) = getimagesize($file->getRealPath());
            // $widthreal = $arrayimage['0'];
            // $heightreal = $arrayimage['1'];
            // $width200 = ($widthreal / $heightreal) * 200;
            // $height200 = $width200 / ($widthreal / $heightreal);
            // $img200 = Image::canvas($width200, $height200);
            // $image200 = Image::make($file->getRealPath())->resize($width200, $height200, function ($c) {
            //     $c->aspectRatio();
            //     $c->upsize();
            // });
            // $img200->insert($image200, 'center');
            // $img200->save($resize200);

            // $width800 = ($widthreal / $heightreal) * 800;
            // $height800 = $width800 / ($widthreal / $heightreal);

            // $img800 = Image::canvas($width800, $height800);
            // $image800 = Image::make($file->getRealPath())->resize($width800, $height800, function ($c) {
            //     $c->aspectRatio();
            //     $c->upsize();
            // });
            // $img800->insert($image800, 'center');
            // $img800->save($resize800);

            $configration->inspection_request_image = $fileName;
        }

        $configration->save() ;
        return back()->with('success',trans('home.configurations_updated_successfully'));
    }
}
