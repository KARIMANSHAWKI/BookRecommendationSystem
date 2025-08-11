<?php

namespace App\Models;

use App\Events\BookCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\BookFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\BookFactory>
 */
class Book extends Model
{
    use HasFactory;

    /** @var list<string> */
    protected $fillable = ['name', 'number_of_pages', 'cover', 'description','section_id', 'created_by'];

    /** @var list<string> */
    protected $with = ['section'];

    /** @var array<string, class-string> */
    protected $dispatchesEvents = [
        'saved' => BookCreated::class,
    ];

    /** @return BelongsToMany<User, $this> */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('start_page', 'end_page');
    }

    /** @return BelongsTo<Section, $this> */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    /** @return BelongsTo<User, $this> */
    public function publisher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /** Let PHPStan know the concrete factory type */
    protected static function newFactory(): BookFactory
    {
        return BookFactory::new();
    }
}
