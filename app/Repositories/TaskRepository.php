<?php
namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Model;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    /**
     * @var Model
     */
    protected Model $model;
    /**
     * @param Task $model
     */
    public function __construct(Task $model)
    {
        $this->model = $model;
    }

}
