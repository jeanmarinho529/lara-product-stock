<?php

namespace Tests\Feature;

use App\Models\{Category, Product, User};
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * 1° Check route list products.
 * 2° Check route show products.
 * 3° Create new.
 * 4° Edit product does not belong to the user.
 * 5° Delete product does not belong to the user.
 * 6° Edit product belong to the user.
 * 7° Delete product belong to the user.
 * 8° Movimet product.
 */
class ProductTest extends TestCase
{
    /**
     * List all products.
     *
     * @test
     */
    public function check_route_list_products()
    {
        $response = $this->get(route('api-product-index'));

        $response->assertStatus(200);
    }

    /**
     * List specific products.
     *
     * @test
     */
    public function check_route_show_products()
    {
        $product = Product::factory()->create();
        $response = $this->get(route('api-product-show', $product->slug));

        $response->assertStatus(200);
    }

    /**
     * New product.
     *
     * @test
     */
    public function create_product()
    {
        $user     = User::factory()->create();
        $category = Category::first();
        $token = $user->createToken('API Token')->plainTextToken;

        $payload = ['user_id' => $user->id, 'category_id' => $category->id, 'name' => 'New Product', 'amount' => 7.83, 'current_quantity' => 5];

        
        $response = $this->post(route('api-product-create'), $payload, [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(201);
    }

    /**
     * Edit product does not belong to the user.
     *
     * @test
     */
    public function edit_product_does_not_belong_to_the_user()
    {
        $user = User::whereNotIn('email',['admin@admin.com'])->first();
        $product = Product::whereNotIn('user_id',[$user->id])->first();

        $token = $user->createToken('API Token')->plainTextToken;

        $payload = ['user_id' => $product->id, 'category_id' => $product->category_id, 'name' => $product->name];
        $response = $this->put(route('api-product-update', $product->slug), $payload,[
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(403);
    }

    /**
     * Delete product does not belong to the user.
     *
     * @test
     */
    public function delete_product_does_not_belong_to_the_user()
    {
        $user = User::whereNotIn('email',['admin@admin.com'])->first();
        $product = Product::whereNotIn('user_id',[$user->id])->first();

        $token = $user->createToken('API Token')->plainTextToken;
        
        $response = $this->delete(route('api-product-destroy', $product->slug), [], [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(403);
    }

    /**
     * Edit product belong to the user.
     *
     * @test
     */
    public function edit_product_belong_to_the_user()
    {
        $product = Product::first();
        $user = User::find($product->user_id);

        $token = $user->createToken('API Token')->plainTextToken;

        $payload = ['user_id' => $product->id, 'category_id' => $product->category_id, 'name' => $product->name];

        $response = $this->put(route('api-product-update', $product->slug), $payload,[
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(204);
    }

    /**
     * Delete product belong to the user.
     *
     * @test
     */
    public function delete_product_belong_to_the_user()
    {
        $product = Product::factory()->create();
        $user = User::find($product->user_id);

        $token = $user->createToken('API Token')->plainTextToken;
        
        $response = $this->delete(route('api-product-destroy', $product->slug), [], [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(204);
    }

    /**
     * Movimet product.
     *
     * @test
     */
    public function movimet_product()
    {
        $product = Product::factory()->create();
        $user = User::find($product->user_id);

        $token = $user->createToken('API Token')->plainTextToken;
        
        // Add quantity.
        $payload = ['quantity' => $product->current_quantity];

        $response = $this->post(route('api-product-movement', $product->slug), $payload, [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(204);
        
        // Withdraw quantity surpass that has.
        $payload = ['quantity' => $product->current_quantity * (-3)];

        $response = $this->post(route('api-product-movement', $product->slug), $payload, [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(409);

        // Withdraw quantity.
        $payload = ['quantity' => $product->current_quantity * (-2)];

        $response = $this->post(route('api-product-movement', $product->slug), $payload, [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(204);
    }
}
