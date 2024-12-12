<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\PageRequest;
use App\Models\Page;

class PageController extends Controller
{

public function __construct()
    {
       $this->middleware('permission:pages');
    }

    public function index()
    {
        //
        $pages = Page::all();
        return view('admin.pages.pages',compact('pages'));
    }


    public function create()
    {
        //
        return view('admin.pages.addPage');
    }


    public function store(PageRequest $request)
    {
        $data =$request->validated() ;
        Page::create($data);
        return redirect('admin/pages')->with('success',trans('home.your_item_added_successfully'));
    }




    public function edit($id)
    {

        $page = Page::find($id);
        if($page){
            return view('admin.pages.editPage',compact('page'));
        }else{
            abort('views.404');
        }

    }

    public function update(PageRequest $request, $id)
    {
        $data =$request->validated() ;
        $page = Page::find($id);
        if(!$page){
            return redirect()->back()->withErrors(trans('home.not_found'));
        }
        $page->update($data) ;
        return redirect('admin/pages')->with('success',trans('home.your_item_updated_successfully'));
    }

    public function destroy($ids)
    {
        //
         $ids = explode(',', $ids);
        if ($ids[0] == 'on') {
            unset($ids[0]);
        }
        foreach ($ids as $id) {
            $m = Page::findOrFail($id);
            $m->delete();
        }
    }
}
