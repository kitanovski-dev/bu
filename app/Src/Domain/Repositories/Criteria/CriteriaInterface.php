<?php

namespace App\Src\Domain\Repositories\Criteria;

interface CriteriaInterface
{
    public function withCriteria(...$criteria);
}
