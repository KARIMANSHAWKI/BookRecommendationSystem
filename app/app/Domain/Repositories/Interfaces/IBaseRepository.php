<?php

namespace App\Domain\Repositories\Interfaces;

interface IBaseRepository
{
    public function all($relations,  $paginationLimit);
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
