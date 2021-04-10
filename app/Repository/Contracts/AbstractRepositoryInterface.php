<?php

namespace App\Repository\Contracts;

interface AbstractRepositoryInterface
{
    public function get($fields = ['*']);

    public function create($fields);

    public function find($id, $fields = ['*']);

    public function update($id, $fields);

    public function delete($id);

}