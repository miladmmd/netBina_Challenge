<?php
namespace App\Traits;

use App\Models\Task;
use Carbon\Carbon;

trait ValidateTasks
{


    public function isConfirmed($id): bool
    {
        $task = Task::findOrFail($id);

        return $task->confirmed_by ? true : false;
    }

    /**
     * @param $id
     * @return bool
     */
    public function isDeadlineDelay($id): bool
    {

            $task = Task::findOrFail($id);

            $now = Carbon::parse( \Carbon\Carbon::now()->toDateString());

            $deadline = Carbon::parse($task->deadline);


        return $now->gt($deadline) ? true : false;
    }



    public function isExpireTime($deadline)
    {
        $now = Carbon::parse( \Carbon\Carbon::now()->toDateString());

        $deadline = Carbon::parse($deadline);

        return $now->gt($deadline) ? true : false;

    }

    /**
     * @param $user_id
     * @param $task_id
     * @return bool
     */
    public function isTaskRelatedToUser($user_id,$task_id)
    {
        $user =  \App\Models\User::with('tasks')->find($user_id);

        $userTasks = collect($user['tasks']) ;

        return $userTasks->contains(function ($value,$key) use ($task_id){

            return $value['id'] == $task_id;

        });
    }

}
