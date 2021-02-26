<?php

namespace App\Repositories\Production;


use App\Repositories\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    protected $querySearchTargets = [];

    /**
     * EloquentRepository constructor.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Find a model by its primary key.
     *
     * @param  mixed $id
     * @param  array $columns
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public function find($id, $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }

    /**
     * Execute the query as a "select" statement.
     *
     * @param  array $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all($columns = ['*'])
    {
        return $this->model
            ->orderBy('created_at', 'DESC')
            ->get($columns);
    }

    /**
     * Get a new query builder for the model's table.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function allWithBuilder()
    {
        return $this->model->newQuery();
    }

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
    public function paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
    {
        return $this->model
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage, $columns, $pageName, $page);
    }

    /**
     * Save a new model and return the instance.
     *
     * @param  array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($data)
    {
        return $this->model->create($data);
    }

    /**
     * Update the model in the database.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  array $attributes
     * @param  array $options
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update(Model $model, array $attributes = [], array $options = [])
    {
        $model->update($attributes, $options);
        return $model;
    }

    /**
     * Delete the model from the database.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return bool|null
     *
     * @throws \Exception
     */
    public function destroy(Model $model)
    {
        return $model->delete();
    }

    /**
     * Get the first record matching the attributes.
     *
     * @param  array $attributes
     * @param  array $values
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function findByAttributes(array $attributes)
    {
        return $this
            ->model
            ->where($attributes)
            ->first();
    }

    /**
     * Get multiple records matching the attributes.
     *
     * @param  array $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getByAttributes(array $attributes, $orderBy = null, $sortOrder = 'asc')
    {
        $query = $this->model->newQuery();
        if ($orderBy !== null) {
            $query->orderBy($orderBy, $sortOrder);
        }
        return $query
            ->where($attributes)
            ->get();
    }

    /**
     * Find multiple models by their primary keys.
     *
     * @param  \Illuminate\Contracts\Support\Arrayable|array $ids
     * @param  array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findMany($ids, $columns = ['*'])
    {
        return $this->model->findMany($ids, $columns);
    }

    public function deleteModel($model)
    {
        $model->status = Constant::STATUS_DELETE;
        return $model->save();
    }

    public function delete($model)
    {
        return $model->delete();
    }

    public function buildQueryByFilter($query, $filter)
    {
        $tableName = $this->model->getTable();

        $query = $this->queryOptions($query);

        if (count($this->querySearchTargets) > 0 && array_key_exists('query', $filter)) {
            $searchWord = array_get($filter, 'query');
            if (!empty($searchWord)) {
                $query = $query->where(function($q) use ($searchWord) {
                    foreach ($this->querySearchTargets as $index => $target) {
                        if ($index === 0) {
                            $q = $q->where($target, 'LIKE', '%'.$searchWord.'%');
                        } else {
                            $q = $q->orWhere($target, 'LIKE', '%'.$searchWord.'%');
                        }
                    }
                });
            }
            unset($filter['query']);
        }

        foreach ($filter as $column => $value) {
            if (is_array($value)) {
                $query = $query->whereIn($tableName.'.'.$column, $value);
            } else {
                $query = $query->where($tableName.'.'.$column, $value);
            }
        }

        return $query;
    }

    public function queryOptions($query)
    {
        return $query;
    }

    public function buildOrder($query, $filter, $order, $direction)
    {
        if (!empty($order)) {
            $direction = empty($direction) ? 'asc' : $direction;
            $query     = $query->orderBy($order, $direction);
        }

        return $query;
    }

    public function allByFilter($filter, $order = null, $direction = null)
    {
        $query = $this->buildQueryByFilter($this->model, $filter);
        $query = $this->buildOrder($query, $filter, $order, $direction);

        return $query->get();
    }

    public function filterPagination($filter, $pagin = 20, $order = null, $direction = null, $relations = [])
    {
        $query = $this->buildQueryByFilter($this->model, $filter);
        $query = $this->buildOrder($query, $filter, $order, $direction);
        $query = $this->buildRelationship($query, $relations);

        return $query->paginate($pagin);
    }

    public function firstByKey($value)
    {
        $query = $this->model->find($value);

        return $query;
    }

    public function deleteByFilter($filter)
    {
        $query = $this->buildQueryByFilter($this->model, $filter);
        return $query->delete();
    }

    protected function buildRelationship($model, $relations = [])
    {
        return $model->with($relations);
    }
}
