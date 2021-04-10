<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class PopularCategoryDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:popular-category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Popular Category Database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $response = Http::get('https://api.mercadolibre.com/sites/MLB/categories');

            if ($response->successful()) {
                foreach (json_decode($response) as $category) {
                    Category::firstOrCreate([
                        'name' => $category->name
                    ]);
                }

                $this->info('End of command ' . date('Y-m-d H:i:s'));
                $this->info('Registered categories ' . Category::count());
                return true;
            }

            $this->info('Unexpected error');
            return false;

        } catch(\Exception $e) {
            $this->info('Unexpected error');
            info($e);
            return false;
        }
    }
}
