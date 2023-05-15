<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class EventTypeCriteria
 * @package namespace App\Criteria;
 */
class EventTypeCriteria implements CriteriaInterface
{
    private $type;

    public function __construct($type)
    {
      if (is_array($type)) {
          $this->type = collect($type)
                        ->map(function($i) {
                          return intval($i);
                        })
                        ->toArray();
      }
      else{
        $this->type = intval($type);
      }

    }

        /**
         * Apply criteria in query repository
         *
         * @param                     $model
         * @param RepositoryInterface $repository
         *
         * @return mixed
         */
        public function apply($model, RepositoryInterface $repository)
        {
            if (is_array($this->type)) {
                return $model->whereIn('type', $this->type);
            }

            return $model->where('type', $this->type);
        }
  }
