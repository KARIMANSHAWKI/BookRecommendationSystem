<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/** @phpstan-use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\UserFactory> */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'phone'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * @return BelongsToMany<Book, $this>   // <-- match PHPStan’s inferred $this
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class)->withPivot('start_page', 'end_page');
    }

    /**
     * Explicitly declare the factory so PHPStan knows TFactory.
     */
    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
