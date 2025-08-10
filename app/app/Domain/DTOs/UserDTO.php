<?php

declare(strict_types=1);

namespace App\Domain\DTOs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserDTO extends DataTransferObject
{
    public string $name;

    public string $password;
    public string $phone;

    public string $email;
    public string $image;


    public static function fromRequest(array|Model $request): DataTransferObject
    {
        return new self([
            'name' => optional($request)['name'],
            'email' =>  optional($request)['email'],
            'phone' => optional($request)['phone'],
            'password' => optional($request)['password'] ?  Hash::make($request['password']) : null,
            'image' => optional($request)['image'] ? uploadImage($request['image']) : null,
        ]);
    }
}
