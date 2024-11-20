<?php

namespace App\Http\Controllers;

use App\Helpers\SaveImageTo3Path;
use App\Http\Requests\ReportRequest;
use App\Models\Report;

class CounterController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:counters');
    }
    public function index()
    {
        $data['reports'] = Report::all();
        return view('admin.counters.index', $data);
    }

    public function create()
    {
        return view('admin.counters.create');
    }

    public function store(ReportRequest $request)
    {
        try {
           
            $newReport = $request->validated();
            if ($request->hasFile("icon")) {
                $SaveImage = new SaveImageTo3Path($request->file('icon'));
                $newReport['icon'] = $SaveImage->saveImages('reports');
            }
            Report::create($newReport);
            return redirect()->back()->with('success', __('home.your data has been added successfully'));
        } catch (\Throwable $th) {
            dd( $th);
            return redirect()->back()->withErrors(__('home.server error'));
        }
    }

    public function edit($report)
    {
        $data['report'] = Report::find($report);
        return view('admin.counters.edit', $data);
    }

    public function update(ReportRequest $request,$report)
    {
        try {
            $report = Report::find($report);
            $reportUpdate = $request->validated();
            if ($request->hasFile("icon")) 
            {
                $SaveImage = new SaveImageTo3Path($request->file('icon'));
                $reportUpdate['icon'] = $SaveImage->saveImages('reports');
                SaveImageTo3Path::deleteImage($report->icon, 'reports');
            }
            $report->update($reportUpdate);
            return redirect()->back()->with('success', __('home.your data has been updated successfully'));
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(__('home.server error'));
        }
    }
    public function destroy($ids)
    {
        $ids = explode(',', $ids);
        if ($ids[0] == 'on') {
            unset($ids[0]);
        }
        
        foreach ($ids as $id) {
            $report = Report::findOrFail($id);
            SaveImageTo3Path::deleteImage($report->icon, 'reports');
            $report->delete();
        }
    }

    
}
