<?php
namespace App\Domain\Services\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Section;

interface ISectionManagementService
{
   public function list(int $perPage = 15): LengthAwarePaginator;
   public function get(Section $section): Section;
   public function create(array $data): Section;
   public function update(Section $section, array $data): Section;
   public function delete(Section $section): bool;
}
