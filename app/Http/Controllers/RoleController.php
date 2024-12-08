<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    public function index()
    {
        //
        $roles = Role::all();
        return view('admin.roles.roles',compact('roles'));
    }


    public function create()
    {
        $permissions= Permission::all();
        return view('admin.roles.addRole',compact('permissions'));
    }


    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);
        return redirect('admin/roles');
    }


    public function edit($id)
    {
        //
        $role = Role::find($id);
        $allPermissions= Permission::all();
        $rolePermissions= $role->permissions()->pluck('name')->toArray();
        return view('admin.roles.editRole',compact('role','allPermissions','rolePermissions'));
    }


    public function update(Request $request, $id)
    {
        //
        $role = Role::find($id);
        $role->name= $request->name;
        $role->save();

        $rolePermissions= $role->permissions()->get();
        foreach($rolePermissions as $rolePermission){
            $role->revokePermissionTo($rolePermission);
        }

        $role->syncPermissions($request->permissions);
        return redirect('admin/roles');
    }


    public function destroy($ids)
    {
        //
        $ids = explode(',', $ids);
        if ($ids[0] == 'on') {
            unset($ids[0]);
        }
        foreach ($ids as $id) {
            $role = Role::findOrFail($id);
            $role->delete();
        }
    }
}
