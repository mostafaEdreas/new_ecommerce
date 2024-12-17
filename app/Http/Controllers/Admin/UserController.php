<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SaveImageTo3Path;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Spatie\Permission\Models\Role;

class UserController extends Controller
{


    public function index()
    {
        $users = User::where('is_admin',0)->get();
        return view('admin.users.users',compact('users'));
    }

    

    public function admins(){
        $admins = User::where('is_admin',1)->get();
        return view('admin.users.admins',compact('admins'));
    }
    

    public function create()
    {
        //
        $roles = Role::get();
        return view('admin.users.addUser',compact('roles'));
    }


    public function store(UserRequest $request)
    {


        $data = $request->validated();
        // $data['remember_token'] = request('remamber')?Str::random(80):'';
        $data['password'] = bcrypt($request->password);
        if ($request->hasFile("image")) {
            $file = $request->file("image");
            $saveImage = new SaveImageTo3Path($file,true);
            $fileName = $saveImage->saveImages('users');
            $data['image'] = $fileName;
        }

       $user = User::create($data);

       if ($request->filled('role')) {
            $user->syncRoles($request->role);
        }
    
        return redirect()->back()->with('success',trans('home.your_item_added_successfully'));
    }



    public function edit(User $user)
    {
        //
        $user->admin_seen =1;
        $user->save();
        $roles = Role::get();
        $userRoles = $user->roles ->pluck('name') ->toArray();
        return view('admin.users.editUser',compact('user','roles','userRoles'));
    }


    public function update(UserRequest $request, $id)
    {
        $update = User::find($id);
       
        if($update){
            $data = $request->validated();

            if ($data['password']) {
                $data['password'] = bcrypt($data['password']);
            }else{
                unset($data['password']);
            }
            if ($request->hasFile("image")) {
                $file = $request->file("image");
                $saveImage = new SaveImageTo3Path($file,true);
                $fileName = $saveImage->saveImages('users');
                SaveImageTo3Path::deleteImage( $update->image, 'users');
                $data['image'] = $fileName;
            }
    
            $update->update($data);
            if(request('checkout')){
               return redirect()->back()->withInput();
            }
           DB::table('model_has_roles')->where('model_id',$update->id)->delete();
            
            if ($request->role){
                $roles=$request->role;
                foreach ($roles as $role) {
                    $update->assignRole($role);
                }
            }
            return redirect()->back()->with('success',trans('home.your_item_updated_successfully'));
    
        }
        return abort(404);
    }


    public function destroy(User $user)
    {
        $user->delete();
    }
}
