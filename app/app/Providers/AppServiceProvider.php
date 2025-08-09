<?php

namespace App\Providers;

use App\Domain\Repositories\Classes\UserRepository;
use App\Domain\Repositories\Interfaces\IUserRepository;
use App\Domain\Services\Classes\AuthService;
use App\Domain\Services\Classes\BookService;
use App\Domain\Services\Classes\UserService;
use App\Domain\Services\Interfaces\IAuthService;
use App\Domain\Services\Interfaces\IBookService;
use App\Domain\Services\Interfaces\IUserService;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // app, bind , scoped
        $this->app->scoped(IAuthService::class, AuthService::class);
        $this->app->scoped(IBookService::class, BookService::class);
        $this->app->scoped(IUserService::class, UserService::class);

        $this->app->scoped(IUserRepository::class, function ($app) {
            $app->resolve(UserRepository::class, User::class);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
