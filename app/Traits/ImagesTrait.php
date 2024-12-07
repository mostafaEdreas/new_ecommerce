<?php
namespace App\Traits;

use App\Helpers\SaveImageTo3Path;
use App\Http\Requests\ImageRequest;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;

trait ImagesTrait {
  

    private function saveImages(ImageRequest $request , Model $model ){
        $data = $request->validated() ;
        foreach ($data['images'] as $key => $file) {
            $saveImage = new SaveImageTo3Path($file,true);
            $fileName = $saveImage->saveImages('images');
            Image::create(['image'=> $fileName ,'imageable_id' => $model->id ,'imageable_type' => $model->getMorphClass()]);
        }
        
        return true ;
    
    }


    public function removeImages($id ){
    
      if($id = request('id')){
        return  Image::find($id)->delete()
        ? redirect()->back()->with( 'success',__('home.your_item_deleted_successfully')) 
        : redirect()->back()->withErrors(__('home.an error occurred'));
      }
    }

}
