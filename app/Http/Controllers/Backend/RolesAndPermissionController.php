<?php

namespace App\Http\Controllers\Backend;

use App\Data\Role\RoleData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionController extends Controller
{
    
    public function roles(Request $request){
        $roles = (new RoleData($request))->getAllRoles();
        return view('backend.pages.roles.index', compact('roles'));
    }


    public function addRole(){
        return view('backend.pages.roles.add-form');
    }

    public function storeRole(Request $request){
        
        $request->validate([
            'role' => 'required|alpha_dash|unique:roles,name'
        ]);

        DB::beginTransaction();
        try{
            (new RoleData($request))->storeRole();

            DB::commit();
            flash()->addSuccess('Role created successfully');
            return redirect()->route('user.roles');
        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('error', $e);
        }
    }

    public function editRole(Request $request, $id){
        $role = (new RoleData($request))->findRole($id);
        $selectedPermissions = $role->permissions()->pluck('id')->toArray();
        $permissions = Permission::get()->groupBy(function ($item, $key) {
            return explode('-', $item->name)[0];
        });
        return view('backend.pages.roles.form', compact('role', 'permissions', 'selectedPermissions'));
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required',
                'permission' => ['required', 'array'],
                'permission.*' => ['required', 'exists:permissions,id']
            ]
        );
        try {
            (new RoleData($request))->updateRole($id);
            return redirect()->route('user.roles')->with('success', 'Permissions updated successfully');
        } catch (\Throwable $th) {
            request()->session()->flash(
                'error',
                $th->getMessage()
            );
            return redirect()->back()->withInput();
        }
    }


}
