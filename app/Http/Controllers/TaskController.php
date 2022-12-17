<?php
namespace App\Http\Controllers;

use App\Http\Requests\AssignTaskRequest;
use App\Http\Requests\ConfirmTaskRequest;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\TaskServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{

    private $taskService;

    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * @param TaskRequest $request
     * @return JsonResponse
     */
    public function store(TaskRequest $request)
    {
        DB::beginTransaction();

        try {
            $request['created_by'] = auth()->user()->id;

            $task =  $this->taskService->repository()->create($request->only([
                'title','deadline','created_by'
            ]));

        } catch (\Throwable $e){
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }

        DB::commit();

        return response()->json(new TaskResource($task), Response::HTTP_OK);
    }

    /**
     * @param AssignTaskRequest $request
     * @return JsonResponse
     */
    public function assign(AssignTaskRequest $request)
    {
        DB::beginTransaction();

        try {
            $allocator = auth()->user();

            /** check user with gate that is last person that task  assign to it   */
            $task = $this->taskService->repository()->findById($request['task_id']);
            $this->authorize('assign-task', $task);

            $this->taskService->assignToUser($request['task_id'],$allocator,$request['user_id']);

        }catch (\Throwable $e){
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }

        DB::commit();

        return response()->json(new TaskResource($this->taskService->repository()->findById($request['task_id'],['*'],['users'])), Response::HTTP_OK);
    }

    /**
     * @param ConfirmTaskRequest $request
     * @return JsonResponse
     */
    public function confirm(ConfirmTaskRequest $request)
    {

        DB::beginTransaction();

        try {

            $user = auth()->user();

            /** check user with gate that is last person that task  assign to it   */
            $task = $this->taskService->repository()->findById($request['task_id']);
            $this->authorize('assign-task', $task);

            $this->taskService->confirmTask($request['task_id'],$user->id);

        }catch (\Throwable $e){
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
        DB::commit();
        return response()->json(new TaskResource($this->taskService->repository()->findById($request['task_id'],['*'],['users'])), Response::HTTP_OK);
    }

}
