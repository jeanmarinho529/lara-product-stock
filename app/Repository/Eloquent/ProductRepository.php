<?php

namespace App\Repository\Eloquent;

use App\Models\Product;
use App\Repository\Contracts\ProductRepositoryInterface;

class ProductRepository extends AbstractRepository implements ProductRepositoryInterface
{

    protected $model = Product::class;

    public function listProducts($fields = ['id','category_id','name','slug','amount','current_quantity','minimum_quantity'])
    {
        return $this->model->with('category:id,name')->select($fields)->get();
    }

    public function findProduct($slug, $fields = ['*'])
    {
        return $this->model->with('category:id,name')->select($fields)->whereSlug($slug)->firstOrFail();
    }

    public function createProduct($fields)
    {
        $fields['user_id'] = auth()->user()->id;
        return $this->model->create($fields);
    }

    public function updateProduct($slug, $fields)
    {
        return $this->model->whereSlug($slug)->firstOrFail()->update($fields);
    }

    public function deleteProduct($slug)
    {
        return $this->model->whereSlug($slug)->firstOrFail()->delete();
    }
}
