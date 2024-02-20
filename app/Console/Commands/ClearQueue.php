<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Queue;

class ClearQueue extends Command
{
    protected $signature = 'queue:clear';
    protected $description = 'Delete all pending jobs from the queue';

    public function handle()
    {
        try {
            Queue::flush();

            $this->info('Queue cleared successfully');
        } catch (\Exception $e) {
            $this->error('Failed to clear the queue');
            $this->error($e->getMessage());
        }
    }
}

