<?php

namespace App\Http\Controllers;

use App\Models\IntroSlider;
use DB;
use File;
use Image;
use Illuminate\Http\Request;

class IntroSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware(['permission:intro-sliders']);
    }

    public function index()
    {
        //
        $sliders = IntroSlider::orderBy('id','DESC')->get();
        return view('admin.sliders.intro-sliders.sliders',compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.sliders.intro-sliders.addSlider');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $add = new IntroSlider();
        $add->title = $request->title;
        $add->text = $request->text;
        $add->link = $request->link;
        $add->order = $request->order;
        $add->lang = $request->lang;
        if($request->status){
            $add->status = 1;
        }else{
            $add->status = 0;
        }

        if ($request->hasFile("image")) {

            $file = $request->file("image");
            $mime = File::mimeType($file);
            $mimearr = explode('/', $mime);

            // $destinationPath = base_path() . '/uploads/'; // upload path
            $destinationPath = base_path('uploads/sliders/intro-sliders/source/');
            $extension = $mimearr[1]; // getting file extension
            $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
            $file->move($destinationPath, $fileName);

            $add->image = $fileName;
        }
        $add->save();
        return redirect('admin/intro-sliders')->with('success',trans('home.your_item_added_successfully'));
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
        $slider=IntroSlider::find($id);
        if($slider){
            return view('admin.sliders.intro-sliders.editSlider',compact('slider'));
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
        $add = IntroSlider::find($id);
        $add->title = $request->title;
        $add->text = $request->text;
        $add->link = $request->link;
        $add->order = $request->order;
        $add->lang = $request->lang;

        if($request->status){
            $add->status = 1;
        }else{
            $add->status = 0;
        }

        
        if ($request->hasFile("image")) {

            $file = $request->file("image");
            $mime = File::mimeType($file);
            $mimearr = explode('/', $mime);

            $destinationPath = base_path('uploads/sliders/intro-sliders/source/');
            $extension = $mimearr[1]; // getting file extension
            $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
            $file->move($destinationPath, $fileName);

            $add->image = $fileName;
        }
        $add->save();
        return redirect('/admin/intro-sliders')->with('success',trans('home.your_item_updated_successfully'));
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
        $destinationPath = base_path('uploads/sliders/intro-sliders/source/');
        
        foreach ($ids as $id) {
            $slider = IntroSlider::findOrFail($id);

            if ($slider->image != null) {
                unlink(sprintf($destinationPath . '%s', $slider->image));
            }

            $slider->delete();
        }
    }  
    
}
