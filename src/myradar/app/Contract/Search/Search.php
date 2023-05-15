<?php

namespace App\Contract\Search;

interface Search {
    public function search($paginate = true, $select = ['*']);
}
