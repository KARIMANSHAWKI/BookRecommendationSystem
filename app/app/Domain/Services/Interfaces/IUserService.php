<?php

namespace App\Domain\Services\Interfaces;

interface IUserService
{
    public function listUsers();

    public function createUser(array $data);

    public function updateUser(array $data, int $userId);

    public function deleteUser($user);
}
