<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeRequest;
use App\Http\Requests\AttributeValueRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;

use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class AttributeController extends Controller
{

    public function __construct(){
        $this->middleware(['permission:attributes']);
    }


    public function index()
    {
        $attributes = Attribute::get();
        return view('admin.attributes.attributes',compact('attributes'));
    }


    public function create()
    {
        return view('admin.attributes.addAttribute');
    }


    public function store(AttributeRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $attribute = Attribute::create($data) ;
            foreach ($data['value_ar'] as $key => $value) {
               $attribute->values()->create(['value_ar'=> $value , 'value_en' => $data['value_en'][$key]]) ;
            }
            DB::commit();
            return redirect()->back()->with('success',trans('home.your_item_added_successfully'));

        } catch (Exception $ex) {
            DB::rollBack();
            Log::error('Transaction failed', ['exception' => $ex]);
            return redirect()->back()->withErrors($ex->getMessage());
        }

    }




    public function edit($id)
    {
        $attribute=Attribute::with('values')->find($id);

        return view('admin.attributes.editAttribute',compact('attribute'));
    }


    public function update(AttributeRequest $request, $id)
    {

        $attribute = Attribute::findOrFail($id);
        try {

            DB::beginTransaction();
            $data = $request->validated();
            $attribute ->update($data) ;
            $attribute ->refresh() ;
            foreach (array_key_exists('value_ar' ,$data) ? $data['value_ar'] : [] as $key => $value) {
               $attribute->values()->create(['value_ar'=> $value , 'value_en' => $data['value_en'][$key]]) ;
            }
            DB::commit();
            return redirect()->back()->with('success',trans('home.your_item_updated_successfully'));

        } catch (Exception $ex) {
            DB::rollBack();
            Log::error('Transaction failed', ['exception' => $ex]);
            return redirect()->back()->withErrors($ex->getMessage());
        }

    }


    public function destroy($id)
    {

        if( request('id')){
            request()->validate([
                'id' => 'array|min:1|',
                'id.*' => 'exists:attributes,id'
            ]);
            $ids =  request('id') ;

            $delete = Attribute::whereIn('id',$ids)->delete();

            // check if comming from ajax
            if(request()->ajax()){
                // check is is deleted or has any exception
                if( $delete != 1 ){
                    return response()->json(['message'=> $delete??__('home.an messages.error entering data')],422);
                }
                return response()->json(['message'=>trans('home.your_items_deleted_successfully')]);
            }
            if( $delete != 1 ){
                return redirect()->back()->withErrors( $delete??__('home.an messages.error entering data'));
            }
            return redirect()->back()->with('success',trans('home.your_items_deleted_successfully'));
        }elseif($aboutStruc = Attribute::find($id)){
               // check is is deleted or has any exception
            $aboutStruc->delete();
            if(request()->ajax()){
                return response()->json(['message'=>trans('home.your_item_deleted_successfully')]);
            }
            return redirect()->back()->with('success',trans('home.your_item_deleted_successfully'));
        }
    }


    public function updateAttributeValue(AttributeValueRequest $request){
        $attributeValue = AttributeValue::find($request->value_id);
        $attributeValue->value_en = $request->value_en;
        $attributeValue->value_ar = $request->value_ar;
        $attributeValue->save();
        return back()->with('success',trans('home.your_attribute_value_updated_successfully'));

    }

    public function removeAttributeValue(){
        $valId = request()->validate(['value_id' => 'required|in:attibute_values']);
        AttributeValue::find($valId['value_id'])->delete();
    }

    public function addColor(){
        if($data['attribute']  = Attribute::create(['name_en' => 'color' , 'name_ar' => 'اللون' , 'status' => '1' ]) ){
            return redirect()->route( 'attributes.edit' ,$data['attribute']->id)->with( 'success' ,__('home.your home.your_item_added_successfully'));;
        }
        return redirect()->back()->withErrors( __('home.an error occurred'));
    }
}
