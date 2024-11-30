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
        if( request('ids')){
            $ids =  request('ids') ;
            $ids = is_array(   $ids ) ?    $ids  : [ $ids ];
            Address::whereIn('id',$ids)->delete();
            return redirect()->back()->with('success',trans('home.your_items_deleted_successfully'));
        }elseif($address = Address::find($id)){
            $address->delete();
            return redirect()->back()->with('success',trans('home.your_item_deleted_successfully'));
        }

    }
}
