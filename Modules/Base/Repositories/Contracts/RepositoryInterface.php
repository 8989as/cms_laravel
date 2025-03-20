<?php

namespace Modules\Base\Repositories\Contracts;

interface RepositoryInterface
{
    public function getAll(array $columns = ['*']);
    public function find(int $id, array $columns = ['*']);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}