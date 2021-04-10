<?php

namespace Database\Seeders;

use App\Models\{Product, User};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategorySeeder::class,
            UserSeeder::class,
            ProductSeeder::class
        ]);

        User::factory(10)->create();
        Product::factory(10)->create();
    }
}
