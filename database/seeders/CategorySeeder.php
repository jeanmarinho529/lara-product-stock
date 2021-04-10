<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Alimentos', 'Produto de limpeza', 'Móveis'];
        
        foreach ($categories as $category){
            Category::firstOrCreate(['name' => $category]);
        }
    }
}
