<?php

namespace App\Repository\Contracts;

interface ProductRepositoryInterface extends AbstractRepositoryInterface
{
    public function listProducts($fields = ['id','category_id','name','slug','amount','current_quantity','minimum_quantity']);

    public function findProduct($slug, $fields = ['*']);

    public function updateProduct($slug, $fields);

    public function deleteProduct($slug);

    public function createProduct($fields);
}
