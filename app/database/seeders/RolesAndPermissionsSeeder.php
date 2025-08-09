<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guard = 'web';

        // create permissions
        Permission::firstOrCreate(['name' => 'manage users','guard_name' => $guard]);
        Permission::firstOrCreate(['name' => 'edit books','guard_name' => $guard]);
        Permission::firstOrCreate(['name' => 'delete books','guard_name'=>$guard]);
        Permission::firstOrCreate(['name'=>'create books','guard_name'=>$guard]);

        // section permissions
        Permission::firstOrCreate(['name' => 'view sections','guard_name' => $guard]);
        Permission::firstOrCreate(['name' => 'create sections','guard_name' => $guard]);
        Permission::firstOrCreate(['name' => 'edit sections','guard_name' => $guard]);
        Permission::firstOrCreate(['name' => 'delete sections','guard_name' => $guard]);

        // optional: assigning book to section (separate from edit books)
        Permission::firstOrCreate(['name' => 'assign books','guard_name' => $guard]);
        // … add more permissions as needed …

        // create roles and assign existing permissions
        $admin = Role::firstOrCreate(['name' => 'admin','guard_name' => $guard]);
        $publisher = Role::firstOrCreate(['name' => 'publisher', 'guard_name' => $guard]);
        $section_manager=Role::firstOrCreate(['name'=>'section_manager','guard_name'=>$guard]);

        $publisher->syncPermissions(['create books']);
        $admin->syncPermissions(Permission::where('guard_name',$guard)->get());
        $section_manager->syncPermissions(['assign books','view sections','create sections', 'edit sections','delete sections']);

        Role::firstOrCreate(['name' => 'user','guard_name' => $guard]);
    }
}
