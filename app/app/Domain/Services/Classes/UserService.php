<?php

namespace App\Domain\Services\Classes;

use App\Domain\Repositories\Interfaces\IUserRepository;
use App\Domain\Services\Interfaces\IUserService;

class UserService extends AbstractService implements IUserService
{
    public function __construct()
    {
        parent::__construct(resolve( IUserRepository::class));
    }
}
