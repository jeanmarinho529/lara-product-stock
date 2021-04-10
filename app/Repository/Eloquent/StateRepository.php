<?php

namespace App\Repository\Eloquent;

use App\Models\State;
use App\Repository\Contracts\StateRepositoryInterface;

class StateRepository extends AbstractRepository implements StateRepositoryInterface
{

    protected $model = State::class;

}
