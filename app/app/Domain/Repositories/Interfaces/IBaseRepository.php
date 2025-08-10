<?php

namespace App\Domain\Repositories\Interfaces;

interface IBaseRepository
{
    public function all(array $relations = [],?int $paginationLimit = null);
    public function find(int $id): mixed;
    public function create(array $data): mixed;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
