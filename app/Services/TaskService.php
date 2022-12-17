<?php
namespace App\Services;

use App\Models\User;
use App\Repositories\TaskRepositoryInterface;
use App\Traits\ValidateTasks;

 class TaskService implements TaskServiceInterface
{

    use ValidateTasks;

    /**
     * @var TaskRepositoryInterface
     */
    protected $taskRepository;

    /**
     * @param TaskRepositoryInterface $taskRepository
     */
    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @return TaskRepositoryInterface
     */
    public function repository(): TaskRepositoryInterface
    {
        return $this->taskRepository;
    }

    /**
     * sync user(The person for whom the task is assigned) and allocator(The person who assigned the task)
     * @param int $task_id
     * @param User $allocator
     * @param int $user_id
     * @return void
     */
    public function assignToUser(int $task_id, User $allocator, int $user_id):void
    {
         $task = $this->taskRepository->findById($task_id);

         $task->users()->syncWithoutDetaching([$user_id=>['allocator_id'=>$allocator->id,'allocator_email'=>$allocator->email]]);

         $this->taskRepository->update($task->id,['last_assigned_user_id'=>$user_id]);
    }

    /**
     * change status task to confirm
     * @param $task_id
     * @param $user_id
     * @return void
     */
    public function confirmTask($task_id,$user_id):void
    {

        $this->taskRepository->update($task_id,['confirmed_by'=>$user_id,'status'=>'confirm']);

    }

    /**
     * chane all pending task if deadline past
     * @return void
     */
    public function changePendingTaskToDelay():void
    {

        foreach (\App\Models\Task::pendingTask()->cursor() as $task){

            if($this->isDeadlineDelay($task->id)){

                $this->taskRepository->update($task->id,['status'=>'delayed']);

            }

        }
    }
}
