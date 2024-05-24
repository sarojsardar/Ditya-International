<?php
namespace App\Data\Role;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class RoleData {

    protected $request;

    public function __construct(Request $request = null){
        $this->request = $request;
    }


    public function storeRole(){

        Role::create([
            'name' => $this->request->role,
        ]);

    }

    public function getAllRoles(){
        $roles = Role::withCount(['users', 'permissions'])->get();
        return $roles;
    }

    public function findRole($id){
        $role = Role::findorfail($id);
        return $role;
    }

    public function updateRole($id){
        $role = $this->findRole($id);
        $role->update(['name' => $this->request->name]);
        $role->permissions()->sync($this->request->permission);
    }

}

?>