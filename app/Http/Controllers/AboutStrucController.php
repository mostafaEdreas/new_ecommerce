<?php

namespace App\Http\Controllers;

use App\Helpers\SaveImageTo3Path;
use App\Http\Controllers\Controller;
use App\Http\Requests\AboutStrucRequest;
use App\Http\Requests\MenuRequest;
use App\Models\AboutStruc;
use App\Models\Menu;


class AboutStrucController extends Controller
{

    public function __construct(){
        $this->middleware(['permission:aboutStrucs']);
    }
    public function index()
    {
        $data['aboutStrucs'] = AboutStruc::get();
        return view('admin.aboutStrucs.aboutStrucs',$data);
    }


    public function create()
    {
        $data['aboutStrucs'] = AboutStruc::get();
        return view('admin.aboutStrucs.addAboutStruc');
    }


    public function store(AboutStrucRequest $request)
    {

        $data  = $request->validated() ;
        if ($request->hasFile("image")) {

            $file = $request->file("image");
            $saveImage = new SaveImageTo3Path($file,true);
            $fileName = $saveImage->saveImages('aboutStrucs');
            $data['image'] = $fileName;
        }
        AboutStruc::create( $data);
        return redirect()->back()->with('success',trans('home.your_item_added_successfully'));
    }


    public function edit(AboutStruc $aboutStruc)
    {
        if($data['aboutStruc'] = $aboutStruc){
            return view('admin.aboutStrucs.editAboutStruc',$data);        
        }
        return abort(404);
    }


    public function update(AboutStrucRequest $request,AboutStruc $aboutStruc)
    {
       
        if( $aboutStruc){
            $data  = $request->validated() ;
            if ($request->hasFile("image")) {
                $file = $request->file("image");
                $saveImage = new SaveImageTo3Path($file,true);
                $fileName = $saveImage->saveImages('aboutStrucs');
                SaveImageTo3Path::deleteImage(  $aboutStruc->image, 'aboutStrucs');
                $data['image'] = $fileName;
            }
            $aboutStruc->update( $data);
            return redirect()->back()->with('success',trans('home.your_item_updated_successfully'));
        }

        return abort(404);    
    }


    public function destroy($id)
    {

        $ids =  request('ids') ;
        $ids = is_array(   $ids ) ?    $ids  : [ $ids ];
        AboutStruc::whereIn('id',$ids)->delete();
        return redirect()->back()->with('success',trans('home.your_item_deleted_successfully'));

    }
}
