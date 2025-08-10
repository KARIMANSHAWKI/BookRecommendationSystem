<?php

namespace App\Domain\Services\Classes;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class AbstractService
{
    public function __construct(protected $repository)
    {
    }


    public function list(): LengthAwarePaginator
    {
        return $this->repository->all();
    }

    public function get(int $id)
    {
        return $this->repository->find(id: $id);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->repository->update(id: $id, data: $data);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
