<?php

namespace Tests\Feature;

use App\Models\Category;
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
        $response = $this->get('/api/v1/categoreis');

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
        $response = $this->post(route('api-category-create'), [
            'name' => 'New category'
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
        $category = Category::select('id','name')->first();
        info($category->id);
        $response = $this->put(route('api-category-update', $category->id), [
            'name' => $category->name
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
        $category = Category::select('id','name')->orderBy('id','desc')->first();
        $response = $this->delete(route('api-category-destroy', $category->id));

        $response->assertStatus(204);
    }
}
