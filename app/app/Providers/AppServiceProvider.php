<?php

namespace App\Providers;

use App\Domain\Repositories\Classes\BaseRepository;
use App\Domain\Repositories\Classes\BookRepository;
use App\Domain\Repositories\Classes\UserRepository;
use App\Domain\Repositories\Interfaces\IBaseRepository;
use App\Domain\Repositories\Interfaces\IBookRepository;
use App\Domain\Repositories\Interfaces\IUserRepository;
use App\Domain\Services\Classes\AuthService;
use App\Domain\Services\Classes\BookService;
use App\Domain\Services\Classes\UserService;
use App\Domain\Services\Interfaces\IAuthService;
use App\Domain\Services\Interfaces\IBookService;
use App\Domain\Services\Interfaces\IUserService;
use App\Models\Book;
use App\Models\User;
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

        $this->app->scoped(IBookRepository::class, function ($app) {
            return new BookRepository(new Book());
        });

        $this->app->scoped(IUserRepository::class, function ($app) {
            return new UserRepository(new User());
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
