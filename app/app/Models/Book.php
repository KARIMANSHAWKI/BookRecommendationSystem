<?php

namespace App\Models;

use App\Events\BookCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'number_of_pages', 'cover', 'description','section_id', 'created_by'];

    protected $with = ['section'];

    protected $dispatchesEvents = [
        'saved' => BookCreated::class,
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('start_page', 'end_page');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function publisher()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
