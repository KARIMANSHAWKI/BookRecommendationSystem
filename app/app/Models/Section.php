<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\SectionFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
/**
 * @use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\SectionFactory>
 */
class Section extends Model
{
   use HasFactory;

    /** @var list<string> */
   protected $fillable = ['name','description'];

    /** @return HasMany<Book, $this> */
    public function books(): HasMany
   {
       return $this->hasMany(Book::class);
   }

    /** Let PHPStan know the concrete factory type */
    protected static function newFactory(): SectionFactory
    {
        return SectionFactory::new();
    }
}
