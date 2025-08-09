<?php

namespace App\Domain\DTOs;

use Illuminate\Http\UploadedFile;

class UpdateUserData
{
   public ?string       $name;
   public ?string       $email;
   public ?string       $password;
   public ?string       $phone;
   public ?UploadedFile $image;

   public function __construct(array $data)
   {
      $this->name     = $data['name']     ?? null;
      $this->email    = $data['email']    ?? null;
      $this->password = $data['password'] ?? null;
      $this->phone    = $data['phone']    ?? null;
      $this->image    = $data['image']    ?? null;
   }
}
