<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactusRequest;
use App\Models\ContactUs;

use App\Traits\SeoTrait;
use Illuminate\Support\Facades\Request;

class ContactUsController extends Controller
{

    use SeoTrait;

    public function index()
    {

        list($data['schema'], $data['metatags']) = $this->contactUsPageSeo();
        return view('website.contact-us.index',$data);
    }

    public function store(ContactusRequest $request){

        $contact = ContactUs::create($request->validated()) ;
        $data = array('contact' => $contact);
//        Mail::send('emails/contact_email', $data, function ($msg) use ($setting) {
//            $msg->to($setting->contact_email, 'Naguib Selim')->subject('Contact Us');
//            $msg->from(config('mail.from.address'), config('mail.from.name'));
//        });

        if(request()->ajax()){
            return response()->json(['message' => trans('home.Thank you for contacting us. A customer service officer will contact you soon')]);
        }
        return back()->with(['message' => trans('home.Thank you for contacting us. A customer service officer will contact you soon')]);

    }

}
