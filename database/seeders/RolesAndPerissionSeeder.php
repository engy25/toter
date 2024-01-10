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
    //     $permission=Permission::create([
    //   "name"=>"view Deliveries",
    //   "guard_name"=>"web"
    // ]);

    // $permission = Permission::create([
    //   "name" => "view Districts",
    //   "guard_name" => "web"
    // ]);

    // $permission = Permission::create([
    //   "name" => "show Delivery",
    //   "guard_name" => "web"
    // ]);


    // $permission = Permission::create([
    //   "name" => "view Coupon",
    //   "guard_name" => "web"
    // ]);


    // $permission = Permission::create([
    //   "name" => "search traditional_users",
    //   "guard_name" => "web"
    // ]);
    // $permission = Permission::create([
    //   "name" => "add traditional_users",
    //   "guard_name" => "web"
    // ]);

    // $permission = Permission::create([
    //   "name" => "add order to traditional_users",
    //   "guard_name" => "web"
    // ]);

    $role1 = Role::where('name', 'DataEntry')->where('guard_name', 'web')->first();
    $role2 = Role::where('name', 'CallCenter')->where('guard_name', 'web')->first();
    $role3 = Role::where('name', 'Admin')->where('guard_name', 'web')->first();
    // $permission1 = Permission::findByName('view Countries');
    // $permission2=Permission::findByName('view Cities');

    // $permission3 = Permission::findByName('view SubSections');
    // $permission4 = Permission::findByName('view Stores');
    //$permission5 = Permission::findByName('view Items');
    //  $permission6 = Permission::findByName('view Offers');
    // $role1->givePermissionTo($permission1);
    // $role1->givePermissionTo($permission2);
    // $permission7 = Permission::findByName('view Districts');
    // $role1->givePermissionTo($permission7);

    // $permission8 = Permission::findByName('view Deliveries');
    // $role1->givePermissionTo($permission8);

    // $permission9 = Permission::findByName('show Delivery');
    // $role1->givePermissionTo($permission9);
    // $permission10 = Permission::findByName('view Coupon');
    // $role1->givePermissionTo($permission10);

    // $permission11 = Permission::findByName('view traditional_users');
    // $role2->givePermissionTo($permission11);

    // $permission12 = Permission::findByName('search traditional_users');
    // $role2->givePermissionTo($permission12);

    // $permission13 = Permission::findByName('add traditional_users');
    // $role2->givePermissionTo($permission13);

    // $permission14 = Permission::findByName('add order to traditional_users');
    // $role2->givePermissionTo($permission14);

    $permission15 = Permission::findByName('add permission to roles');
    $role3->givePermissionTo($permission15);

    $user = User::whereId(100)->first();
    // $user->givePermissionTo('view Cities');
    // $user->givePermissionTo('view Countries');
    // $user->givePermissionTo('view Districts');
    // $user->givePermissionTo('view Deliveries');
   // $user->givePermissionTo('show Delivery');
    // $user->givePermissionTo('view Coupon');
    // $user->givePermissionTo('view traditional_users');
    // $user->givePermissionTo('search traditional_users');
    // $user->givePermissionTo('add traditional_users');
    // $user->givePermissionTo('add order to traditional_users');
  }
}
