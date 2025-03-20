<?php

namespace Modules\Base\Services;

use Modules\Base\Repositories\Contracts\RepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseService
{
    protected $repository;
    protected $transformer;

         /**
     * BaseService constructor.
     *
     * @param RepositoryInterface $repository
     * @param string|null $transformer Class name of the transformer
     */
    public function __construct(RepositoryInterface $repository, ?string $transformer = null)
    {
        $this->repository = $repository;

        // Store the transformer class name (not instantiated yet)
        $this->transformer = $transformer;
    }


    /**
     * Retrieve all data and apply the transformer.
     *
     * @param array $columns
     * @param array $relations
     * @return mixed
     */
    public function getAll(array $columns = ['*'], array $relations = [])
    {
        $data = $this->repository->getAll($columns, $relations);
        return $this->transformData($data);
    }

    /**
     * Retrieve paginated data and apply the transformer.
     *
     * @param int $perPage
     * @param array $columns
     * @param array $relations
     * @return mixed
     */
    public function getPaginated(int $perPage = 15, array $columns = ['*'], array $relations = [])
    {
        $paginatedData = $this->repository->getPaginated($perPage, $columns, $relations);
        return $this->transformPaginatedData($paginatedData);
    }

    /**
     * Find a single record and apply the transformer.
     *
     * @param int $id
     * @param array $columns
     * @return mixed
     */
    public function find(int $id, array $columns = ['*'])
    {
        $data = $this->repository->find($id, $columns);
        return $this->transformData($data);
    }

    /**
     * Create a new record and apply the transformer.
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $createdData = $this->repository->create($data);
        return $this->transformData($createdData);
    }

    /**
     * Update an existing record and apply the transformer.
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        $updatedData = $this->repository->update($id, $data);
        return $this->transformData($updatedData);
    }

    /**
     * Delete a record.
     *
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }

    /**
     * Transform single data using the transformer.
     *
     * @param mixed $data
     * @return mixed
     */
    protected function transformData($data)
    {
        if ($this->transformer && $data) {
            return new $this->transformer($data);
        }

        return $data;
    }

    /**
     * Transform paginated data using the transformer.
     *
     * @param \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginatedData
     * @return mixed
     */
    protected function transformPaginatedData($paginatedData)
    {
        if ($this->transformer && $paginatedData) {
            $paginatedData->getCollection()->transform(function ($item) {
                return new $this->transformer($item);
            });
        }

        return $paginatedData;
    }
}