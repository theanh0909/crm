<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * Find a model by its primary key.
     *
     * @param  mixed $id
     * @param  array $columns
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public function find($id, $columns = ['*']);

    /**
     * Execute the query as a "select" statement.
     *
     * @param  array $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all($columns = ['*']);

    /**
     * Get a new query builder for the model's table.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function allWithBuilder();

    /**
     * Paginate the given query.
     *
     * @param  int $perPage
     * @param  array $columns
     * @param  string $pageName
     * @param  int|null $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     *
     * @throws \InvalidArgumentException
     */
    public function paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null);

    /**
     * Save a new model and return the instance.
     *
     * @param  array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($data);

    /**
     * Update the model in the database.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  array $attributes
     * @param  array $options
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update(Model $model, array $attributes = [], array $options = []);

    /**
     * Delete the model from the database.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return bool|null
     *
     * @throws \Exception
     */
    public function destroy(Model $model);

    /**
     * Get the first record matching the attributes.
     *
     * @param  array $attributes
     * @param  array $values
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function findByAttributes(array $attributes);

    /**
     * Get multiple records matching the attributes.
     *
     * @param  array $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getByAttributes(array $attributes, $orderBy = null, $sortOrder = 'asc');

    /**
     * Find multiple models by their primary keys.
     *
     * @param  \Illuminate\Contracts\Support\Arrayable|array $ids
     * @param  array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findMany($ids, $columns = ['*']);

    public function deleteModel($model);

    public function delete($model);

    public function buildQueryByFilter($query, $filter);

    public function queryOptions($query);

    public function buildOrder($query, $filter, $order, $direction);

    public function allByFilter($filter, $order = null, $direction = null);

    public function filterPagination($filter, $pagin = 20, $order = null, $direction = null, $relations = []);

    public function firstByKey($value);

    public function deleteByFilter($filter);
}
