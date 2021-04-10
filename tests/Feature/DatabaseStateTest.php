<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DatabaseStateTest extends TestCase
{
    /**
     * Cehck states table.
     *
     * @test
     */
    public function check_states_table()
    {
        $this->assertTrue(
            Schema::hasTable('states')
        );
    }

    /**
     * Check states column
     * 
     * user_id : int not null
     * name: string not null
     * initials: char not null
     * created_at: date not null
     * updated_at: date not null
     * 
     * @test
     */
    public function check_states_column()
    {
        $this->assertTrue(
            Schema::hasColumns('states', [
                'id',
                'name',
                'initials',
                'created_at',
                'updated_at',
            ])
        );
    }

    /**
     * Check State model
     *  
     * @test
     */
    public function check_state_model()
    {
        $this->assertTrue(class_exists('App\Models\State'));
    }
}
