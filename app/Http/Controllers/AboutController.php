<?php

namespace App\Http\Controllers;

use App\Helpers\FileSave;
use App\Helpers\SaveImageTo3Path;
use App\Http\Requests\AboutRequest;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Models\About;
use App\Models\Menu;


class AboutController extends Controller
{

    public function __construct(){
        $this->middleware(['permission:about']);
    }


    public function editAbout()
    {
        $about = About::first();
        return view('admin.about.editAbout',compact('about'));
    }
    public function update(AboutRequest $request)
    {
        $about = About::first();
        $data = $request->validated();
        foreach ($request->file() as $key =>$file ) {
            if (in_array($key,['image','icon'])) {
 
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
