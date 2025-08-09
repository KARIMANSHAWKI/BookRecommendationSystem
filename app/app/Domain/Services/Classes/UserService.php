<?php

namespace App\Domain\Services\Classes;

use App\Domain\Repositories\Interfaces\IUserRepository;
use App\Domain\Services\Interfaces\IUserService;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;

class UserService implements IUserService
{

    public function __construct(
       private readonly IUserRepository $userRepository
    )
    {
    }

    public function listUsers(): Collection
    {
        return $this->userRepository->all();
    }

    public function createUser(array $data): Application|array|string|Translator|\Illuminate\Contracts\Foundation\Application|null
    {
        $this->userRepository->create($data);
        return trans('message.created');
    }

    public function updateUser(array $data, int $userId): Application|array|string|Translator|\Illuminate\Contracts\Foundation\Application|null
    {
        $this->userRepository->update(id: $userId, data: $data);
        return trans('message.updated');
    }

    public function deleteUser($user): Application|array|string|Translator|\Illuminate\Contracts\Foundation\Application|null
    {
        $this->userRepository->delete(id: $user->id);
        return trans('message.deleted');
    }
}
