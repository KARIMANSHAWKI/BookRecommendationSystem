<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
   use HasFactory;

   protected $fillable = ['name','description'];

   public function books()
   {
       return $this->hasMany(Book::class);
   }
}
