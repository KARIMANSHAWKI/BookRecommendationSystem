<?php

namespace App\Domain\Services\Classes;

use App\Domain\DTOs\UserDTO;
use App\Domain\Repositories\Interfaces\IUserRepository;
use App\Domain\Services\Interfaces\IAuthService;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Throwable;

class AuthService implements IAuthService
{

    public function __construct(protected IUserRepository $userRepository)
    {
    }

    /**
     * @throws Throwable
     */
    public function login(array $data)
    {
        $user = User::query()->where('email', Arr::get($data, 'email'))->first();
        throw_if(!Auth::attempt($data) || !$user, trans('message.invalid_user'));

        return $this->generateToken($user);
    }

    public function register(UserDTO $data)
    {
        $user = $this->userRepository->create((array)$data);

        return $this->generateToken($user);
    }


    private function generateToken($user)
    {
        return $user->createToken($user->name, [])?->plainTextToken;
    }
}
