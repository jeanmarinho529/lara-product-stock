<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DatabaseProductTest extends TestCase
{
     /**
     * Cehck products table.
     *
     * @test
     */
    public function check_products_table()
    {
        $this->assertTrue(
            Schema::hasTable('products')
        );
    }

    /**
     * Check products column.
     * 
     * user_id : int not null
     * category_id : int not null
     * name: string not null
     * description : string
     * slug : string not null
     * amount : decimal not null
     * current_quantity: integer not null
     * minimum_quantity : integer not null
     * created_at: date not null
     * updated_at: date not null
     * deleted_at: date
     * 
     * @test
     */
    public function check_products_column()
    {
        $this->assertTrue(
            Schema::hasColumns('products', [
                'user_id',
                'category_id',
                'name',
                'description',
                'slug',
                'amount',
                'current_quantity',
                'minimum_quantity',
                'created_at',
                'updated_at',
                'deleted_at'
            ])
        );
    }

    /**
     * Check Prodcut model
     *  
     * @test
     */
    public function check_products_model()
    {
        $this->assertTrue(class_exists('App\Models\Product'));
    }
}
