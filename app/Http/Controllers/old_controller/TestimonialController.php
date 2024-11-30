<?php

namespace App\Http\Controllers;

use App\Helpers\SaveImageTo3Path;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use DB;
use File;
use Image;

class TestimonialController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:testimonials');
    }


    public function index()
    {
        $testimonials = Testimonial::get();
        return view('admin.testimonials.testimonials',compact('testimonials'));
    }


    public function create()
    {
        return view('admin.testimonials.addTestimonial');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $add = new Testimonial();
        $add->name = $request->name;
        $add->position = $request->position;
        $add->text = $request->text;
        $add->lang = $request->lang;
        $add->status = $request->status;
        if ($request->hasFile("img")) {
            $SaveImage = new SaveImageTo3Path($request->file('img'));
            $fileName = $SaveImage->saveImages('testimonials');
            $add->img = $fileName;
        }
        $add->save();
        return redirect('admin/testimonials')->with('success',trans('home.your_item_updated_successfully'));
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
        $testimonial = Testimonial::find($id);
        if($testimonial){
            return view('admin.testimonials.editTestimonial',compact('testimonial'));
        }else{
            abort('404');
        }

    }


    public function update(Request $request, $id)
    {
        $add = Testimonial::find($id);
        $add->name = $request->name;
        $add->position = $request->position;
        $add->text = $request->text;
        $add->lang = $request->lang;
        $add->status = $request->status;
        if ($request->hasFile("img")) {
            $SaveImage = new SaveImageTo3Path($request->file('img'));
            $fileName = $SaveImage->saveImages('testimonials');
            SaveImageTo3Path::deleteImage( $add->img,'testimonials');
            $add->img = $fileName;
        }
        $add->save();
        return redirect('admin/testimonials')->with('success',trans('home.your_item_updated_successfully'));
    }


    public function destroy($ids)
    {
        $ids = explode(',', $ids);
        if ($ids[0] == 'on') {
            unset($ids[0]);
        }

        foreach ($ids as $id) {
            $testimonial = Testimonial::findOrFail($id);
            SaveImageTo3Path::deleteImage( $testimonial->img,'testimonials');
            $testimonial->delete();
        }
    }
}
