<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\MenuRequest;
use App\Models\Address;
use App\Models\Menu;


class AddressController extends Controller
{

    public function __construct(){
        $this->middleware(['auth']);
    }
    public function index()
    {
        $addresses = Address::where('user_id',auth()->user()->id)->get();
        return view('admin.aboutStrucs.index',compact('aboutStrucs'));
    }


    public function create()
    {
        return view('admin.aboutStrucs.create');
    }


    public function store(AddressRequest $request)
    {

        $data =$request->validated() ;
        $data['user_id'] = auth()->user()->id ;
        Menu::create( $data);
        return redirect()->back()->with('success',trans('home.your_item_added_successfully'));
    }


    public function edit($id)
    {
        if($address = Address::find($id)){
            return view('admin.aboutStrucs.edit',compact('address'));
        }
        return abort(404);
    }


    public function update(AddressRequest $request,$id)
    {
        $data =$request->validated() ;
        $data['user_id'] = auth()->user()->id ;

        if( $update = Address::find($id)){
            $update->update($request->validated());
            return redirect()->back()->with('success',trans('home.your_item_updated_successfully'));
        }

        return abort(404);
    }


    public function destroy($id)
    {

        if( request('id')){
            request()->validate([
                'id' => 'array|min:1|',
                'id.*' => 'exists:addresses,id'
            ]);
            $ids =  request('id') ;
           
            $delete = Address::whereIn('id',$ids)->delete();
            // check if comming from ajax
            if(request()->ajax()){
                // check is is deleted or has any exception
                if( !$delete ){
                    return response()->json(['message'=> $delete??__('home.an messages.error entering data')],422);
                }
                return response()->json(['message'=>trans('home.your_items_deleted_successfully')]);
            }
            if( !$delete ){
                return redirect()->back()->withErrors( $delete??__('home.an error has occurred. Please contact the developer to resolve the issue'));
            }
            return redirect()->back()->with('success',trans('home.your_items_deleted_successfully'));
        }elseif($aboutStruc = Address::find($id)){
               // check is is deleted or has any exception
               $delete = $aboutStruc->delete();
            if(request()->ajax()){
                if( !$delete ){
                    return response()->json(['message'=> $delete??__('home.an messages.error entering data')],422);
                }
                return response()->json(['message'=>trans('home.your_item_deleted_successfully')]);
            }
            if( !$delete ){
                return redirect()->back()->withErrors( $delete??__('home.an error has occurred. Please contact the developer to resolve the issue'));
            }
            return redirect()->back()->with('success',trans('home.your_item_deleted_successfully'));
        }
    }
}
