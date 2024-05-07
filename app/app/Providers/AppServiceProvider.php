<?php

namespace App\Providers;

use App\Domain\Services\Classes\AuthService;
use App\Domain\Services\Classes\BookService;
use App\Domain\Services\Interfaces\IAuthService;
use App\Domain\Services\Interfaces\IBookService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->scoped(IAuthService::class, AuthService::class);
        $this->app->scoped(IBookService::class, BookService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
