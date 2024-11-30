<?php

namespace App\Http\Controllers;

use App\Helpers\SaveImageTo3Path;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{


    public function __construct(){
        $this->middleware(['permission:home-sliders']);
    }

    public function index()
    {
        //
        $data['sliders'] = Slider::orderBy('id','DESC')->get();
        return view('admin.sliders.home-sliders.sliders', $data);
    }


    public function create()
    {
        //
        return view('admin.sliders.home-sliders.addSlider');
    }


    public function store(SliderRequest $request)
    {
        $data = $request->validated();
      

        if ($request->hasFile("image")) {
            $file = $request->file("image");
            $saveImage = new SaveImageTo3Path($file,true);
            $fileName = $saveImage->saveImages('aboutStrucs');
            $data['image'] = $fileName;
        }
        Slider::create($data);
        return redirect()->back()->with('success',trans('home.your_item_added_successfully'));
    }




    public function edit($id)
    {
        $slider = Slider::find($id);
        if($slider){
            return view('admin.sliders.home-sliders.editSlider',compact('slider'));
        }else{
            abort('404');
        }
    }


    public function update(SliderRequest $request, $id)
    {
        $slider = Slider::find($id);
        $data = $request->validated();
        if ($request->hasFile("image")) {
            $file = $request->file("image");
            $saveImage = new SaveImageTo3Path($file,true);
            $fileName = $saveImage->saveImages('aboutStrucs');
            SaveImageTo3Path::deleteImage(  $slider->image, 'aboutStrucs');
            $data['image'] = $fileName;
        }
        $slider->update($data);
        return redirect()->back()->with('success',trans('home.your_item_updated_successfully'));
    }


    public function destroy($id)
    {
        if( request('ids')){
            $ids =  request('ids') ;
            $ids = is_array(   $ids ) ?    $ids  : [ $ids ];
            Slider::whereIn('id',$ids)->delete();
            return redirect()->back()->with('success',trans('home.your_items_deleted_successfully'));
        }elseif($address = Slider::find($id)){
            $address->delete();
            return redirect()->back()->with('success',trans('home.your_item_deleted_successfully'));
        }

    }
    
}
