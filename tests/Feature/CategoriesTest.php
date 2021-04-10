<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * 1° Check route list categories
 * 2° Check route show category
 * 3° Create new category
 * 4° User not admin, edit category
 * 5° User not admin, delete category
 * 6° User admin, edit category
 * 7° User admin, delete category
 */
class CategoriesTest extends TestCase
{    
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
        $category = Category::factory()->create();
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
        $user     = User::factory()->create();
        $token = $user->createToken('API Token')->plainTextToken;

        $payload = ['name' => 'New category'];
        
        $response = $this->post(route('api-category-create'), $payload, [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(201);
    }

    /**
     * User is not admin, edit specific category.
     *
     * @test
     */
    public function edit_category_is_not_admin()
    {
        $user = User::first();
        $token = $user->createToken('API Token')->plainTextToken;

        $category = Category::select('id','name')->first();

        $payload = ['name' => $category->name];
        $response = $this->put(route('api-category-update', $category->id), $payload,[
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(401);
    }

    /**
     * User is not admin, delete specific category.
     *
     * @test
     */
    public function delete_category_is_not_admin()
    {
        $user = User::first();
        $token = $user->createToken('API Token')->plainTextToken;
        
        $category = Category::select('id','name')->orderBy('id','desc')->first();

        $response = $this->delete(route('api-category-destroy', $category->id), [], [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(401);
    }

    /**
     * User is admin, edit specific category.
     *
     * @test
     */
    public function edit_category_is_admin()
    {
        $user = User::where('email', '=','admin@admin.com')->first();
        $token = $user->createToken('API Token')->plainTextToken;

        $category = Category::select('id','name')->first();

        $payload = ['name' => $category->name];
        $response = $this->put(route('api-category-update', $category->id), $payload,[
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(204);
    }

    /**
     * User is admin, delete specific category.
     *
     * @test
     */
    public function delete_category_is_admin()
    {
        $user = User::where('email', '=','admin@admin.com')->first();
        $token = $user->createToken('API Token')->plainTextToken;
        
        $category = Category::factory()->create();

        $response = $this->delete(route('api-category-destroy', $category->id), [], [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(204);
    }
}
