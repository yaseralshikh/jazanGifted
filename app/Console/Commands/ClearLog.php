<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the Laravel log file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $logFile = storage_path('logs/laravel.log');

        if (file_exists($logFile)) {
            file_put_contents($logFile, '');
            $this->info('✅ Log file cleared successfully!');
        } else {
            $this->warn('⚠️ Log file does not exist.');
        }
    }
}
