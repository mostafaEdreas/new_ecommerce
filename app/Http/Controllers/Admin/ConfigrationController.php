<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SaveImageTo3Path;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConfigrationRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
class ConfigrationController extends Controller
{
    public function __construct(){
        $this->middleware(['permission:configrations']);
    }

    public function show($lang)
    {
        $data['configrations'] =  (object) Setting::where('lang', $lang)->get()->pluck('value_200', 'key')->toArray();

        $data['edit_lang'] = $lang;
        return view('admin.configrations.configration', $data);
    }


    public function update(ConfigrationRequest $request, $lang)
    {

        try {
            DB::beginTransaction();
            $data = $request->validated() ;
            foreach ($data as $key => $value) {
                $row = Setting::whereLang($lang)
                ->where('key' , $key)->first();
                if (in_array($key , Setting::IMAGES)) {
                    $saveImage = new SaveImageTo3Path($value,true);
                    $fileName = $saveImage->saveImages('settings');
                    SaveImageTo3Path::deleteImage($row->value,'settings');
                    $value = $fileName;
                }

                if($row){
                    $row->update(['value' => $value]);
                }else{
                    Setting::create(['key' => $key , 'value' =>  $value , 'lang' => $lang]);
                }
            }
            DB::commit();

            Cache::forget("settings_$lang");
            Cache::forget("settings_Images");
            Cache::forget("settings_Images_200");

            return back()->with('success',trans('home.configurations_updated_successfully'));
        } catch (\Exception $ex) {
           DB::rollBack() ;
           return redirect()->back()->withErrors($ex->getMessage());
        }

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


        return back()->with('success',trans('home.configurations_updated_successfully'));
    }
}
