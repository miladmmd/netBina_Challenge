<?php
namespace App\Services;

use App\Models\User;
use App\Repositories\TaskRepositoryInterface;

interface TaskServiceInterface
{
    public function repository():TaskRepositoryInterface;
    public function assignToUser(int $task_id, User $allocator, int $user_id):void;
    public function confirmTask($task_id,$user_id):void;
    public function changePendingTaskToDelay():void;
    public function isTaskRelatedToUser($user_id,$task_id);

}
