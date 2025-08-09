<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::query()->updateOrCreate([
            'email' => 'test.user@gmail.com'
        ],[
            'name' => 'Test User',
            'email' => 'test.user@gmail.com',
            'password' => Hash::make('password'),
            'image' => UploadedFile::fake()->image('fake.jpg'),
        ]);
    }
}
