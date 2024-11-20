<?php

namespace App\Http\Controllers;

use App\Helpers\SaveImageTo3Path;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Team;



class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:teams');
    }

    public function index()
    {
        $teams = Team::get();
        return view('admin.teams.teams',compact('teams'));
    }


    public function create()
    {
        return view('admin.teams.addteam');
    }


    public function store(Request $request)
    {
        $add = new Team();
        $add->name = $request->name;
        $add->position = $request->position;
        $add->lang = $request->lang;
        $add->mobile = $request->mobile;
        $add->facebook = $request->facebook;
        $add->instgram = $request->instgram;
        $add->linkedin = $request->linkedin;
        $add->status = $request->status;
        if ($request->hasFile("img")) {
            $SaveImage = new SaveImageTo3Path($request->file('img'));
            $fileName = $SaveImage->saveImages('teams');
            $add->img = $fileName;
        }
        $add->save();
        return redirect('admin/teams')->with('success',trans('home.your_item_updated_successfully'));
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
        $team = Team::find($id);
        if($team){
            return view('admin.teams.editteam',compact('team'));
        }else{
            abort('404');
        }
        
    }


    public function update(Request $request, $id)
    {
        $add = Team::find($id);
        $add->name = $request->name;
        $add->position = $request->position;
        $add->lang = $request->lang;
        $add->mobile = $request->mobile;
        $add->facebook = $request->facebook;
        $add->instgram = $request->instgram;
        $add->linkedin = $request->linkedin;
        $add->status = $request->status;
        if ($request->hasFile("img")) {
            $SaveImage = new SaveImageTo3Path($request->file('img'));
            $fileName = $SaveImage->saveImages('teams');
            SaveImageTo3Path::deleteImage( $add->img,'teams');
            $add->img = $fileName;
        }
        $add->save();
        return redirect('admin/teams')->with('success',trans('home.your_item_updated_successfully'));
    }


    public function destroy($ids)
    {
        $ids = explode(',', $ids);
        if ($ids[0] == 'on') {
            unset($ids[0]);
        }
        foreach ($ids as $id) {
            $team = Team::findOrFail($id);
            SaveImageTo3Path::deleteImage( $team->img,'teams');
            $team->delete();
        }
    }
}
