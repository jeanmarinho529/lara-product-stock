<?php

namespace App\Console\Commands;

use App\Models\State;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class PopularStateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:popular-state';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Popular State Database';

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
            $response = Http::get('https://servicodados.ibge.gov.br/api/v1/localidades/estados');

            if ($response->successful()) {
                foreach (json_decode($response) as $state) {
                    State::firstOrCreate([
                        'name' => $state->nome,
                        'initials' => $state->sigla
                    ]);
                }

                $this->info('End of command ' . date('Y-m-d H:i:s'));
                $this->info('Registered states ' . State::count());
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
