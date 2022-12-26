<?php

namespace App\Repositories\Eloquent;

use App\Exceptions\ModelNotDefined;
use App\Repositories\Contracts\IBase;
use App\Repositories\Criteria\ICriteria;
use Illuminate\Support\Arr;

abstract class BaseRepository implements IBase, ICriteria
{

    protected $model;
    protected $primaryID = 0;

    public function __construct()
    {
        $this->model = $this->getModelClass();
    }

    public function setPrimaryID($id)
    {
        $this->primaryID = $id;
    }

    public function getModelClass()
    {
        if (!method_exists($this, 'model')) {
            throw new ModelNotDefined();
        }
        return app()->make($this->model);
    }

    public function all()
    {
        return $this->primaryID > 0 ? $this->model->where('primary_id', $this->primaryID)->get() : $this->model->get();
    }

    public function find($id)
    {
        return $this->primaryID > 0 ? $this->model->where('primary_id', $this->primaryID)->where('id', $id)->firstOrFail() : $this->model->findOrFail($id);
    }

    public function findWhere($column, $value)
    {
        return $this->model->where($column, $value)->get();
    }

    public function findWhereFirst($column, $value)
    {
        return $this->model->where($column, $value)->firstOrFail();
    }

    public function paginate($perPage = 10)
    {
        return $this->model->paginate($perPage);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $result = $this->model->find($id);
        $result->update($data);
        return $result;
    }

    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }

    public function withCriteria(...$criteria)
    {
        $criteria = Arr::flatten($criteria);
        foreach ($criteria as $criterion) {
            $this->model = $criterion->apply($this->model);
        }
        return $this;
    }
}