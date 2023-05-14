<?php

namespace App\Search;

abstract class BaseModelSearch
{
    private $query;
    private $criteria;

    function __construct()
    {
        $this->query = app()->make($this->init());
        $this->criteria = collect([]);
    }

    public function pushCriteria($criteria)
    {
        $this->criteria->push($criteria);
    }

    abstract protected function init();

    private function applyCriteria()
    {
        foreach ($this->criteria as $key => $criteria) {
            $this->query = $criteria->apply($this->query);
        }
    }

    public function get($paginate = true, $select = ['*'])
    {
        $this->applyCriteria();

        if ($paginate) {
            return $this->query->paginate();
        }

        return $this->query->get($select);
    }
}
