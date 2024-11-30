<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Delivery;
use File;
use Image;

class DeliveryController extends Controller
{

    public function __construct(){
        $this->middleware(['permission:deliveries']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $deliveries = Delivery::all();
        return view('admin.deliveries.deliveries',compact('deliveries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.deliveries.addDelivery');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $add = new Delivery();
        $add->name = $request->name;
        $add->phone1 = $request->phone1;
        $add->phone2 = $request->phone2;
        $add->status = $request->status;
        $add->save();

        return redirect()->route('deliveries.index')->with('success',trans('home.your_item_added_successfully'));
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
        //
        $delivery = Delivery::find($id);
        if($delivery){
            return view('admin.deliveries.editDelivery',compact('delivery'));
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
        //
        $add = Delivery::find($id);
        $add->name = $request->name;
        $add->phone1 = $request->phone1;
        $add->phone2 = $request->phone2;
        $add->status = $request->status;
        $add->save();
        return redirect()->route('deliveries.index')->with('success',trans('home.your_item_updated_successfully'));
    }


    public function destroy($ids)
    {
        $ids = explode(',', $ids);
        if ($ids[0] == 'on') {
            unset($ids[0]);
        }

        // $delivery = Delivery::whereIn('id',$ids)->whereHas('addresses')->get();
        // if(count($delivery) > 0){
        //     if (request()->ajax()) {
        //         response()->json(['message'=>__('home.the item cannot be deleted. There is data related to it')],402);
        //     }
        //     return redirect()->back()->withErrors(__('home.the item cannot be deleted. There is data related to it'));
        // }

        foreach ($ids as $id) {
            Delivery::findOrFail($id)->delete();
        }
    }
}
