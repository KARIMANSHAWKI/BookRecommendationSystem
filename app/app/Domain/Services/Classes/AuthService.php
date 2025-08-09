<?php

namespace App\Domain\Services\Classes;

use App\Domain\Services\Interfaces\IAuthService;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
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
        $user = User::query()->where('email', Arr::get($data, 'email'))->first();

        throw_if(!Hash::check($data['password'], $data['password']) || !$user, trans('message.invalid_user'));

        return $user->createToken('api-token')->plainTextToken;
    }

    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $data['image'] = $this->uploadImage($data['image']);
        $user = User::query()->create($data);
        return  $user->createToken('api-token')->plainTextToken;
    }

    private function uploadImage($file): string
    {
        $imageName = time() . '_' . Str::random(8) . '.' . $file->extension();
        $imagePath = '/users/' . $imageName;

        Storage::disk('public')->put($imagePath, File::get($file));
        return $imagePath;
    }
}
