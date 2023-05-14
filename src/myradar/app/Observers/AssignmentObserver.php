<?php

namespace App\Observers;

use App\Entities\Assignment;
use App\Events\AssignmentCreated;

class AssignmentObserver
{
    public function created(Assignment $model)
    {
        event(new AssignmentCreated($model));
    }
}
