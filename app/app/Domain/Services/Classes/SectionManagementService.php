<?php

namespace App\Domain\Services\Classes;

use App\Domain\Services\Interfaces\ISectionManagementService;
use App\Models\Section;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SectionManagementService implements ISectionManagementService
{
    public function list(int $perPage = 15): LengthAwarePaginator
    {
        return Section::withCount('books')->paginate($perPage);
    }

    public function get(Section $section): Section
    {
        return $section->loadCount('books');
    }

    public function create(array $data): Section
    {
        return Section::create($data);
    }

    public function update(Section $section, array $data): Section
    {
        $section->update($data);
        return $section;
    }

    public function delete(Section $section): bool
    {
       // books keep working because FK is nullable with nullOnDelete()
       return $section->delete();
    }
}
