<?php

namespace App\Domain\Repositories\Classes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class AbstractRepository
{
    public function __construct(private Model $model)
    {
    }

    /**
     * Get all records.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Find a record by ID.
     *
     * @param  int  $id
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Create a new record.
     *
     * @param  array  $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update a record by ID.
     *
     * @param  int    $id
     * @param  array  $data
     * @return Model|null
     */
    public function update(int $id, array $data): ?Model
    {
        $model = $this->find($id);
        if ($model) {
            $model->update($data);
        }
        return $model;
    }

    /**
     * Delete a record by ID.
     *
     * @param  int  $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $model = $this->find($id);
        if ($model) {
            return $model->delete();
        }
        return false;
    }
}
