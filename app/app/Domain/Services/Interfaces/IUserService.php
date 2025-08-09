<?php
namespace App\Domain\Services\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\User;


interface IUserService
{
   public function list(int $perPage = 15): LengthAwarePaginator;
   public function get(User $user): User;
   public function create(array $data): User;
   public function update(User $user, array $data): User;
   public function delete(User $user): bool;
}
