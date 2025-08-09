<?php

namespace App\Domain\DTOs;

use Illuminate\Http\UploadedFile;

class CreateUserData
{
   public string $name;
   public string $email;
   public string $password;
   public ?string $phone;
   public ?UploadedFile $image;

   public function __construct(array $data)
   {
      $this->name     = $data['name'];
      $this->email    = $data['email'];
      $this->password = $data['password'];
      $this->phone    = $data['phone']   ?? null;
      $this->image    = $data['image']   ?? null;
   }
}
