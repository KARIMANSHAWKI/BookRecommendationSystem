<?php

namespace App\Domain\Services\Interfaces;

use App\Domain\DTOs\UserDTO;

interface IAuthService
{

    public function login(array $data);

    public function register(UserDTO $data);

}
