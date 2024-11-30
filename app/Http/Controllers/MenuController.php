<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Models\Menu;
use DB;

class MenuController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:menus');
    }

    public function index()
    {

        $data['menus'] = Menu::where('type','main')->get();
        return view('admin.menus.menus',$data);
    }


    public function create()
    {
     
        return view('admin.menus.addMenu');
    }


    public function store(MenuRequest $request)
    {
       
        Menu::create($request->validated());
        return redirect()->back()->with('success',trans('home.your_item_added_successfully'));
    }


    public function edit($id)
    {

        if( $menu = Menu::find($id)){
            return view('admin.menus.editMenu',compact('menu'));        
        }
        return abort(404);
    }


    public function update(MenuRequest $request,$id)
    {
       
        if( $menu = Menu::find($id)){
            $menu->update($request->validated());
            return redirect()->back()->with('success',trans('home.your_item_updated_successfully'));
        }

        return abort(404);    
    }


    public function destroy()
    {
        $ids =  request('ids') ;
        $ids = is_array(   $ids ) ?    $ids  : [ $ids ];
        Menu::whereIn('id',$ids)->delete();
       
    }
}
