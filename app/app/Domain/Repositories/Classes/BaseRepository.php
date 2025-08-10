<?php

namespace App\Domain\Repositories\Classes;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    public function __construct(private Model $model)
    {
    }

    public function all($relations = [], $paginationLimit = 10)
    {
        return $this->model->with($relations)->paginate($paginationLimit);
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $record = $this->find($id);
        $record->update($data);
        return $record;
    }

    public function delete(int $id)
    {
        return $this->model->destroy($id);
    }
}
