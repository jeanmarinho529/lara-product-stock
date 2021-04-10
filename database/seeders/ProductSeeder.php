<?php

namespace Database\Seeders;

use App\Models\{Category, Product, User};
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::select('id')->first();
        $category = Category::select('id')->where('name','Produto de limpeza')->first();

        $products = [
            ['user_id' => $user->id, 'category_id' => $category->id, 'name' => 'Sabão em pó', 'amount' => 5.41, 'current_quantity' => 2, 'minimum_quantity' => 1],
            ['user_id' => $user->id, 'category_id' => $category->id, 'name' => 'Sabão líquido', 'amount' => 7.83, 'current_quantity' => 5],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
