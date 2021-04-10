<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Database categories
 * 
 * 1° Check table database
 * 2° Check column table
 * 3° Check model State
 */
class DatabaseCategoryTest extends TestCase
{
     /**
     * Cehck categories table.
     *
     * @test
     */
    public function check_categories_table()
    {
        $this->assertTrue(
            Schema::hasTable('categories')
        );
    }

    /**
     * Check categories column.
     * 
     * user_id : int not null
     * name: string not null
     * created_at: date not null
     * updated_at: date not null
     * 
     * @test
     */
    public function check_categories_column()
    {
        $this->assertTrue(
            Schema::hasColumns('categories', [
                'id',
                'name',
                'created_at',
                'updated_at',
            ])
        );
    }

    /**
     * Check Category model
     *  
     * @test
     */
    public function check_category_model()
    {
        $this->assertTrue(class_exists('App\Models\Category'));
    }
}
