<?php

namespace App\Search;

use App\Entities\User;
use App\Criteria\UserEmailCriteria;
use App\Criteria\UserPhoneCriteria;
use Illuminate\Support\Collection;
use App\Contract\Search\UserSearch;

class UserModelSearch extends BaseModelSearch implements UserSearch
{

    function __construct()
    {
        parent::__construct();
    }

    protected function init()
    {
        return User::class;
    }

    public function search($paginate = true, $select = ['*'])
    {
        return $this->get($paginate, $select);
    }
}
