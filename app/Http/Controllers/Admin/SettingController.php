<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function __construct(){
        $this->middleware(['permission:settings']);
    }

    public function index()
    {
        return view('admin.settings.setting');
    }

    public function update(SettingRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated() ;
            foreach ($data as $key => $value) {

                $row = Setting::where(function($q){
                    $q ->whereLang('all')
                    ->orWhereNull('lang');
                })
                ->where('key' , $key)->first();

                if($row){
                    $row->update(['value' => $value]);
                }else{
                    Setting::create(['key' => $key , 'value' =>  $value]);
                }
            }

            DB::commit();
            Cache::forget("settings_ar");
            Cache::forget("settings_en");
            Cache::forget("settings_Images");

            return redirect()->back()->with('success',trans('home.settings_updated_successfully'));
            
        } catch (\Exception $ex) {
           DB::rollBack() ;
           return redirect()->back()->withErrors($ex->getMessage());
        }

    }

}
