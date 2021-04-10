<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoriesTest extends TestCase
{
    // use RefreshDatabase;

    /**
     * List all category.
     *
     * @test
     */
    public function check_route_list_categories()
    {
        $response = $this->get(route('api-category-index'));

        $response->assertStatus(200);
    }

    /**
     * List specific category.
     *
     * @test
     */
    public function check_route_show_category()
    {
        $category = Category::select('id')->first();
        $response = $this->get(route('api-category-show', $category->id));

        $response->assertStatus(200);
    }

    /**
     * New category.
     *
     * @test
     */
    public function create_category()
    {
        $user = User::first();
        $token = $user->createToken('API Token')->plainTextToken;

        $payload = ['name' => 'New category'];
        
        $response = $this->post(route('api-category-create'), $payload, [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(201);
    }

    /**
     * Edit specific category.
     *
     * @test
     */
    public function edit_category()
    {
        $user = User::first();
        $token = $user->createToken('API Token')->plainTextToken;

        $category = Category::select('id','name')->first();

        $payload = ['name' => $category->name];
        $response = $this->put(route('api-category-update', $category->id), $payload,[
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(204);
    }

    /**
     * Delete specific category.
     *
     * @test
     */
    public function delete_category()
    {
        $user = User::first();
        $token = $user->createToken('API Token')->plainTextToken;
        
        $category = Category::select('id','name')->orderBy('id','desc')->first();

        $response = $this->delete(route('api-category-destroy', $category->id), [], [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(204);
    }
}
