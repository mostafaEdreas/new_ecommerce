<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    public function index()
    {

        $permissions= Permission::all();
        return view('admin.permissions.permissions',compact('permissions'));
    }

    public function create()
    {
        //
        return view('admin.permissions.addPermission');
    }

    public function store(Request $request)
    {
        //
        $permission = Permission::create(['name' => $request->name]);
        return redirect('admin/permissions');

    }



    public function edit($id)
    {
        //
        $permission=Permission::find($id);
        return view('admin.permissions.editPermission',compact('permission'));
    }


    public function update(Request $request, $id)
    {
        //
        $permission = Permission::find($id);
        $permission->name = $request->name;
        $permission->save();
        return redirect('admin/permissions');
    }


    public function destroy($ids)
    {
        //
        $ids = explode(',', $ids);
        if ($ids[0] == 'on') {
            unset($ids[0]);
        }
        foreach ($ids as $id) {
            $permission = Permission::findOrFail($id);
            $permission->delete();
        }
    }
}
