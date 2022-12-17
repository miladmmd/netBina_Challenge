<?php
namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public $collects = User::class;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'allocator' => $this->whenPivotLoaded('task_user', function () {
                return User::find($this->pivot->allocator_id);
            }),
            'tasks' => TaskResource::collection($this->tasks),
            'created_task' =>TaskResource::collection($this->createdTask),

        ];
    }
}
