<?php

namespace App\Http\Controllers\dashboard\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\{Permission, Role};

class RolePermissionController extends Controller
{
  /**
   * Assign Permission to the roles
   */
  public function create($roleId)
  {
    $role = Role::where("name","!=","Admin")->whereId($roleId)->first();
    $permissions = Permission::where("guard_name","web")->get();

    return view("content.role.add_rolepermission_model", compact('permissions','role'));
  }

  /**
   * update or store the role permission
   */
  public function store(Request $request,$roleId)
  {
    $role=Role::where("name","!=","Admin")->whereId($roleId)->firstOrFail();

     // Validate the form data, adjust as needed
     $request->validate([
      "permission"=>"array"

     ]);
        // Sync the selected permissions for the role
        $permissions = Permission::whereIn('id', $request->input('permissions', []))->get();
        $role->syncPermissions($permissions);
     return redirect()->route('roles.index')->with('success', 'Roe Permission Added successfully.');

  }
}
