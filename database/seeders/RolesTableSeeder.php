<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $dataEntryRole=DB::table('roles')->insert([
        ['name'=>'Admin','guard_name'=>'web'],
        ['name'=>'Vendor','guard_name'=>'web'],
        ['name'=>'User','guard_name'=>'api'],
        ['name' => 'DataEntry','guard_name'=> 'web']
        // Add more roles as needed
    ]);





    }
}
