<?php

namespace App\Providers;

use App\Domain\Services\Classes\AuthService;
use App\Domain\Services\Classes\BookService;
use App\Domain\Services\Classes\UserService;
use App\Domain\Services\Interfaces\IAuthService;
use App\Domain\Services\Interfaces\IBookService;
use App\Domain\Services\Interfaces\IUserService;
use Illuminate\Support\ServiceProvider;
use App\Domain\Services\Interfaces\IBookManagementService;
use App\Domain\Services\Classes\BookManagementService;
use App\Domain\Services\Interfaces\ISectionManagementService;
use App\Domain\Services\Classes\SectionManagementService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->scoped(IAuthService::class, AuthService::class);
        $this->app->scoped(IBookService::class, BookService::class);
        $this->app->scoped(IUserService::class, UserService::class);
        $this->app->scoped(IBookManagementService::class, BookManagementService::class);
        $this->app->scoped(ISectionManagementService::class, SectionManagementService::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
