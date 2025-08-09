<?php

namespace App\Domain\Services\Classes;

use App\Domain\Services\Interfaces\IUserService;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class UserService implements IUserService
{
   public function list(int $perPage = 15): LengthAwarePaginator
   {
        return User::paginate($perPage);
   }

   public function get(User $user): User
   {
       return $user;
   }

   public function create(array $data): User
   {
           $data['password'] = Hash::make($data['password']);

           if (isset($data['image'])) {
               $data['image'] = $this->uploadImage($data['image']);
           }
           return User::create($data);
   }

   public function update(User $user, array $data): User
   {
           if (isset($data['password'])) {
               $data['password'] = Hash::make($data['password']);
           }

           if (isset($data['image'])) {
               // delete old if exists
               if ($user->image) {
                   Storage::disk('public')->delete($user->image);
               }
               $data['image'] = $this->uploadImage($data['image']);
           }

           $user->update($data);
           return $user;
   }

   public function delete(User $user): bool
   {
      // optionally delete avatar
       if ($user->image) {
           Storage::disk('public')->delete($user->image);
       }
       return $user->delete();
   }

   private function uploadImage($file): string
   {
      $imageName = time() . '_' . Str::random(8) . '.' . $file->extension();
      $path = '/users/' . $imageName;
      Storage::disk('public')->put($path, File::get($file));
      return $path;
   }
}
