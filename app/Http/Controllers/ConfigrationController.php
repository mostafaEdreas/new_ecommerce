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
            $configration->app_logo = $fileName;
        }

        if ($request->hasFile("app_footer_logo")) {

            $saveImage = new SaveImageTo3Path(request()->file('app_footer_logo'),true);
            $fileName = $saveImage->saveImages('settings');
            SaveImageTo3Path::deleteImage($configration->app_footer_logo,'settings');

            $configration->app_footer_logo = $fileName;
        }

        if ($request->hasFile("about_image")) {
            $saveImage = new SaveImageTo3Path(request()->file('about_image'),true);
            $fileName = $saveImage->saveImages('settings');
            SaveImageTo3Path::deleteImage($configration->about_image,'settings');
            $configration->about_image = $fileName;
        }

        if ($request->hasFile("inspection_request_image")) {
            $saveImage = new SaveImageTo3Path(request()->file('inspection_request_image'),true);
            $fileName = $saveImage->saveImages('settings');
            SaveImageTo3Path::deleteImage($configration->inspection_request_image,'settings');
            $configration->inspection_request_image = $fileName;
        }

        $configration->save() ;
        return back()->with('success',trans('home.configurations_updated_successfully'));
    }
}
