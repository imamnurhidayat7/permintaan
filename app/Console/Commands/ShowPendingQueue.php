<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Queue;

class ShowPendingQueue extends Command
{
    protected $signature = 'queue:show';
    protected $description = 'Display the details of pending jobs in the queue';

    public function handle()
    {
        $connection = 'redis'; // Replace this with your queue connection name (e.g., 'redis', 'database', etc.)

        $pendingJobs = Queue::connection($connection)->size();

        $this->info("Total pending jobs in the {$connection} queue: {$pendingJobs}");

        // Use Telescope (optional) to get more detailed information about the pending jobs
        if (class_exists(\Laravel\Telescope\Telescope::class)) {
            $this->line("\nTelescope Pending Jobs:\n");
            \Laravel\Telescope\Telescope::store(\Laravel\Telescope\EntryType::JOB, 'telescope:queue');
            $this->line("You can view the pending jobs in Laravel Telescope.\n");
        }
    }
}