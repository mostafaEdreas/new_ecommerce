<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use File;
use Image;
class SettingController extends Controller
{
    public function __construct(){
        $this->middleware(['permission:settings']);
    }

    public function index()
    {

        return view('admin.settings.setting');
    }

    public function update(Request $request, $id)
    {
        $settings=Setting::first();
        $settings->default_lang = $request->default_lang;
        $settings->contact_email = $request->contact_email;
        $settings->email = $request->email;
        $settings->telphone = $request->telphone;
        $settings->mobile = $request->mobile;
        $settings->fax = $request->fax;
        $settings->facebook = $request->facebook;
        $settings->linkedin = $request->linkedin;
        $settings->instgram = $request->instgram;
        $settings->twitter = $request->twitter;
        $settings->lat = $request->lat;
        $settings->lng = $request->lng;
        $settings->map_url = $request->map_url;
        $settings->whatsapp = $request->whatsapp;
        $settings->snapchat = $request->snapchat;
        $settings->GTM_script = $request->GTM_script;
        $settings->GTM_noscript = $request->GTM_noscript;
        $settings->GTM_id = $request->GTM_id;
        $settings->place_order_msg= $request->place_order_msg;
        $settings->shipping_order_msg= $request->shipping_order_msg;
        $settings->delivered_order_msg= $request->delivered_order_msg;
        $settings->clients = $request->clients;
        $settings->sales = $request->sales;
        $settings->maintenance = $request->maintenance;
        $settings->save();

        return back()->with('success',trans('home.settings_updated_successfully'));
    }

    public function get_free_shipping(){
        $settings =Setting::first();
        return view('admin.settings.free_shipping',compact('settings'));
    }
    public function update_free_shipping(Request $request){
        $settings=Setting::first();
        if($request->free_shipping_status){
            $settings->free_shipping_status=1;
        }else{
            $settings->free_shipping_status=0;
        }
        $settings->free_shipping=$request->free_shipping;
        $settings->save();
        return back()->with('success',trans('home.settings_updated_successfully'));
//        $settings =Setting::first();
//        return view('admin.settings.free_shipping',compact('settings'));
    }


}
