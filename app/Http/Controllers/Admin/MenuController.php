<?php

namespace App\Http\Controllers\Admin;

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

        $data['menus'] = Menu::where('type','main')->get();
        return view('admin.menus.addMenu',$data);
    }


    public function store(MenuRequest $request)
    {

        Menu::create($request->validated());
        return redirect()->back()->with('success',trans('home.your_item_added_successfully'));
    }


    public function edit($id)
    {

        if( $data['menu']= Menu::find($id)){
            $data['menus'] = Menu::where('type','main')->get();
            return view('admin.menus.editMenu',$data);
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


    public function destroy($id)
    {
        if( request('id')){
            $ids =  request('id') ;
            $ids = is_array(   $ids ) ?    $ids  : [ $ids ];
            Menu::whereIn('id',$ids)->delete();
            if(request()->ajax()){
                return response()->json(['message'=>trans('home.your_items_deleted_successfully')]);
            }
            return redirect()->back()->with('success',trans('home.your_items_deleted_successfully'));
        }elseif($aboutStruc = Menu::find($id)){
            $aboutStruc->delete();
            if(request()->ajax()){
                return response()->json(['message'=>trans('home.your_item_deleted_successfully')]);
            }
            return redirect()->back()->with('success',trans('home.your_item_deleted_successfully'));
        }
    }
}
