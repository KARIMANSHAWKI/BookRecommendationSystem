<?php

namespace App\Domain\Services\Classes;

use App\Domain\Services\Interfaces\IAuthService;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class AuthService implements IAuthService
{

    /**
     * @throws Throwable
     */
    public function login(array $data)
    {
        $user = User::query()->where('email', $data['email'])->first();

        throw_if(!Auth::attempt($data) || !$user, trans('message.invalid_user'));
        return $this->generateToken($user);
    }

    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $data['image'] = $this->uploadImage($data['image']);
        $user = User::query()->create($data);
        return $this->generateToken($user);
    }

    private function uploadImage($file): string
    {
        $imageName = time() . '_' . Str::random(8) . '.' . $file->extension();
        $imagePath = '/users/' . $imageName;

        Storage::disk('public')->put($imagePath, File::get($file));
        return $imagePath;
    }

    private function generateToken($user)
    {
        return $user->createToken($user->name, [])?->plainTextToken;
    }
}
