<?php

namespace App\Console\Commands;

use App\Services\TaskServiceInterface;
use Illuminate\Console\Command;

class changeStatusTaskToDelay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:changeStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command check all pending task if expired change it to delay';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(TaskServiceInterface $taskService)
    {
        $taskService->changePendingTaskToDelay();
    }
}
