<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;


class ContactusController extends Controller
{


    public function __construct(){
        $this->middleware(['permission:contact-us']);
    }

    public function index()
    {
        $contactUsMessages = ContactUs::orderBy('id','DESC')->get();
        return view('admin.contactUsMessages.contactUsMessages',compact('contactUsMessages'));
    }







    public function show($id)
    {
        $contactUsMessage = ContactUs::find($id);
        if($contactUsMessage){
            $contactUsMessage->seen = 1;
            $contactUsMessage->save();
            return view('admin.contactUsMessages.contactUsMessage_details',compact('contactUsMessage'));
        }else{
            abort('404');
        }
    }






    public function destroy($id)
    {
        if( request('id')){
            request()->validate([
                'id' => 'array|min:1|',
                'id.*' => 'exists:contact_us,id'
            ]);
            $ids =  request('id') ;

            ContactUs::whereIn('id',$ids)->delete();

            // check if comming from ajax
            if(request()->ajax()){
                return response()->json(['message'=>trans('home.your_items_deleted_successfully')]);
            }

            return redirect()->back()->with('success',trans('home.your_items_deleted_successfully'));
        }elseif($contactUs = ContactUs::find($id)){
               // check is is deleted or has any exception
            $contactUs->delete();
            if(request()->ajax()){
                return response()->json(['message'=>trans('home.your_item_deleted_successfully')]);
            }
            return redirect()->back()->with('success',trans('home.your_item_deleted_successfully'));
        }
    }

}
