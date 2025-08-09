<?php

namespace App\Domain\Services\Interfaces;

interface IAuthService
{

    public function login(array $data);

    public function register(array $data);

}
