<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TopHeader;
use File;
use Image;
class TopHeaderController extends Controller
{
    public function __construct(){
        $this->middleware(['permission:menu-items']);
    }

    public function index()
    {

        $TopHeader =TopHeader::first();
        return view('admin.topHedaer.update',compact('TopHeader'));
    }

    public function update(Request $request)
    {
        $settings=TopHeader::first();
        $settings->text = $request->text;
        $settings->save();

        return back()->with('success',trans('home.your_item_updated_successfully'));
    }


}
