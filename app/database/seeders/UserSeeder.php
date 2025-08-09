<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = User::query()->updateOrCreate([
            'email' => 'admin@gmail.com'
        ],[
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'image' => UploadedFile::fake()->image('fake.jpg'),
        ]);

        $admin = Role::create(['name' => 'admin']);
        $editor = Role::create(['name' => 'editor']);

        $editUsers = Permission::create(['name' => 'edit-user']);
        $deleteUsers = Permission::create(['name' => 'delete-user']);

        $admin->givePermissionTo([$editUsers, $deleteUsers]);
        $editor->givePermissionTo($editUsers);

        $user->assignRole('admin');
    }
}
