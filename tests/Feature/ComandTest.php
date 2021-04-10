<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

/**
 * 1° Test command popular state database
 * 2° Test command popular category database
 */
class ComandTest extends TestCase
{
    /**
     * Check command popular states table.
     *
     * @test
     */
    public function check_command_popular_state_database()
    {
        $this->assertTrue(            
            (boolean)Artisan::call('command:popular-state')
        );
    }

    /**
     * Check command popular categories table.
     *
     * @test
     */
    public function check_command_popular_category_database()
    {
        $this->assertTrue(            
            (boolean)Artisan::call('command:popular-category')
        );
    }
}
