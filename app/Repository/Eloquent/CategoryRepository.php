<?php

namespace App\Repository\Eloquent;

use App\Models\Category;
use App\Repository\Contracts\CategoryRepositoryInterface;

class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface
{

    protected $model = Category::class;

}
