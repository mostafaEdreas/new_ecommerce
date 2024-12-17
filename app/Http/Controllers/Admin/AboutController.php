<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SaveImageTo3Path;
use App\Http\Requests\AboutRequest;

use App\Http\Controllers\Controller;
use App\Models\About;


class AboutController extends Controller
{

    public function __construct(){
        $this->middleware(['permission:about']);
    }


    public function editAbout()
    {
        $about = About::first();
        if(!$about){
            About::create(['title_ar'=> 'no data' ,'title_en'=> 'no data']);
        }
        return view('admin.about.editAbout',compact('about'));
    }
    public function update(AboutRequest $request)
    {
        $about = About::first();
        $data = $request->validated();
        foreach ($request->file() as $key =>$file ) {
            if (in_array($key,['image','banner'])) {
 
                $saveImage = new SaveImageTo3Path($file,true);
                $fileName = $saveImage->saveImages('aboutStrucs');
                SaveImageTo3Path::deleteImage($about->{$key}, 'aboutStrucs');
                $data[$key] = $fileName;
            }
          
        }
       
        $about->update($data);
        return redirect()->back()->with('success',trans('home.about_info_updated_successfully'));
    }

}
