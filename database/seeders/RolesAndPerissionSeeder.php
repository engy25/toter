<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPerissionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    // $permission=Permission::create([
    //   "name"=>"view Cities",
    //   "guard_name"=>"web"
    // ]);
    // $permission=Permission::create([
    //   "name"=>"view Countries",
    //   "guard_name"=>"web"
    // ]);

    // $permission = Permission::create([
    //   "name" => "view Stores",
    //   "guard_name" => "web"
    // ]);

    // $permission = Permission::create([
    //   "name" => "view Items",
    //   "guard_name" => "web"
    // ]);
    // $permission = Permission::create([
    //   "name" => "view SubSections",
    //   "guard_name" => "web"
    // ]);
    // $permission = Permission::create([
    //   "name" => "view Offers",
    //   "guard_name" => "web"
    // ]);

    $permission = Permission::create([
      "name" => "view Districts",
      "guard_name" => "web"
    ]);


    $role1 = Role::where('name', 'DataEntry')->where('guard_name', 'web')->first();
    // $permission1 = Permission::findByName('view Countries');
    // $permission2=Permission::findByName('view Cities');

    // $permission3 = Permission::findByName('view SubSections');
   // $permission4 = Permission::findByName('view Stores');
   //$permission5 = Permission::findByName('view Items');
  //  $permission6 = Permission::findByName('view Offers');
    // $role1->givePermissionTo($permission1);
    // $role1->givePermissionTo($permission2);
    $permission7 = Permission::findByName('view Districts');
    $role1->givePermissionTo($permission7);

    $user = User::whereId(100)->first();
    // $user->givePermissionTo('view Cities');
    // $user->givePermissionTo('view Countries');
    $user->givePermissionTo('view Districts');
  }
}
