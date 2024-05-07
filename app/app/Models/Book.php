<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'number_of_pages', 'cover', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('start_page', 'end_page');
    }
}
