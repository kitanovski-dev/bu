<?php

namespace App\Src\Domain\Repositories;

use App\Src\Domain\Repositories\Criteria\CriteriaInterface;
use Illuminate\Support\Arr;

abstract class AbstractRepository implements CriteriaInterface
{
    protected $entity;

    public function __construct()
    {
        $this->entity = $this->resolveEntity();
    }

    public function create($data)
    {
        return $this->entity->create($data);
    }

    public function withCriteria(...$criteria)
    {
        $criteria = Arr::flatten($criteria);

        foreach ($criteria as $criterion) {
            $this->entity = $criterion->apply($this->entity);
        }
    }

    protected function resolveEntity()
    {
        if(!method_exists($this, 'entity')) {
            throw new NoEntityDefined();
        }

        return app()->make($this->entity());
    }
}
