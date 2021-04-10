<?php

namespace App\Repository\Eloquent;

use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class AbstractRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->resolveModel();
    }

    protected function resolveModel()
    {
        return app($this->model);
    }

    public function get($fields = ['*'])
    {
        return $this->model->select($fields)->get();
    }

    public function create($fields)
    {
        return $this->model->firstOrCreate($fields);
    }

    public function find($id, $fields = ['*'])
    {
        return $this->model->select($fields)->findOrfail($id);
    }

    public function update($id, $fields)
    {
        return $this->model->findOrfail($id)->update($fields);
    }

    public function delete($id)
    {
        return $this->model->findOrfail($id)->delete();
    }
}