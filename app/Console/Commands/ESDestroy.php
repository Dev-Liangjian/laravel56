<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

class ESDestroy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:destroy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'destroy Laravel Scout for search';

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
     * @return mixed
     */
    public function handle()
    {
        $client = new Client();
        $client->delete('http://localhost:9200/elaravel');
        $this->info("delete elasticsearch's index successfully");
    }
}
