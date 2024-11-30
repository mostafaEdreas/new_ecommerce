<?php

namespace App\Http\Controllers;

use App\Helpers\SaveImageTo3Path;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\AttributeRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\CategoryAttribute;
use DB;
use File;
use Image;


class AttributeController extends Controller
{

    public function __construct(){
        $this->middleware(['permission:attributes']);
    }
 

    public function index()
    {
        //
        $attributes = Attribute::get();
        return view('admin.attributes.attributes',compact('attributes'));
    }


    public function create()
    {
        //
        $categories = Category::where('status',1)->get();
        return view('admin.attributes.addAttribute',compact('categories'));
    }


    public function store(AttributeRequest $request)
    {
        $add=new Attribute();
        $add->name_en=$request->name_en;
        $add->name_ar=$request->name_ar;
        if($request->status){
            $add->status=1;
        }else{
            $add->status=0;
        }

        if ($request->hasFile("icon")) {
            $saveImage = new SaveImageTo3Path(request()->file('icon'),true);
            $fileName = $saveImage->saveImages('attributes');

            $add->icon = $fileName;
        }
        $add->save();

        if($request->value_en  && $request->value_ar){
            $valuesInEnglish=$request->value_en;
            $valuesInArabic =$request->value_ar; 
            foreach($valuesInEnglish as $key=>$value){
                if($value && $valuesInArabic[$key]){
                    $attVal=new AttributeValue();
                    $attVal->attribute_id=$add->id;
                    $attVal->value_en=$value;
                    $attVal->value_ar=$valuesInArabic[$key];
                    $attVal->save();
                }
            }
        }
        
        return redirect()->route('attributes.index')->with('success',trans('home.your_item_added_successfully'));
    }




    public function edit($id)
    {
        // $categories=Category::where('status',1)->get();
        $attribute=Attribute::find($id);
        $values=AttributeValue::where('attribute_id',$id)->get();
        // $categories_ids = CategoryAttribute::where('attribute_id', $attribute->id)->pluck('category_id');
        return view('admin.attributes.editAttribute',compact('attribute','values'));
    }


    public function update(AttributeRequest $request, $id)
    {
        $add=Attribute::find($id);
        $add->name_en=$request->name_en;
        $add->name_ar=$request->name_ar;
        if($request->status){
            $add->status=1;
        }else{
            $add->status=0;
        }

        if ($request->hasFile("icon")) {

            $saveImage = new SaveImageTo3Path(request()->file('icon'),true);
            $fileName = $saveImage->saveImages('attributes');
            SaveImageTo3Path::deleteImage($add->icon,'attributes');
            $add->icon = $fileName;
        }
        $add->save();

         if($request->value_en  && $request->value_ar){
            $valuesInEnglish=$request->value_en;
            $valuesInArabic =$request->value_ar; 
            foreach($valuesInEnglish as $key=>$value){
                if($value && $valuesInArabic[$key]){
                    $attVal=new AttributeValue();
                    $attVal->attribute_id=$add->id;
                    $attVal->value_en=$value;
                    $attVal->value_ar=$valuesInArabic[$key];
                    $attVal->save();
                }
            }
        }
        
        return redirect()->route('attributes.index')->with('success',trans('home.your_item_updated_successfully'));
    }


    public function destroy($id)
    {
        if( request('ids')){
            $ids =  request('ids') ;
            $ids = is_array(   $ids ) ?    $ids  : [ $ids ];
            Attribute::whereIn('id',$ids)->delete();
            return redirect()->back()->with('success',trans('home.your_items_deleted_successfully'));
        }elseif($address = Attribute::find(1)){
            $address->delete();
            return redirect()->back()->with('success',trans('home.your_item_deleted_successfully'));
        }

    }

    
    public function updateAttributeValue(Request $request){
        $attributeValue=AttributeValue::find($request->value_id);
        $attributeValue->value_en = $request->value_en;
        $attributeValue->value_ar = $request->value_ar;
        $attributeValue->save();
        return back()->with('success',trans('home.your_attribute_value_updated_successfully'));

    }
    
    public function removeAttributeValue(){
        $valId = $_POST['value_id'];
        AttributeValue::find($valId)->delete();
    }
}
