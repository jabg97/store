<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\PlaceToPay;

class SyncCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'p2p:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PlaceToPay sync cronjob.';

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
        PlaceToPay::sync();
        \Log::info("Cron is working fine!");
        $this->info("Cron is working fine!");
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
     
        require base_path('routes/console.php');
    }
}
