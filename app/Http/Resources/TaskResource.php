<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
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
            'created_by' => $this->created_by,
            'confirmed_by' => $this->confirmed_by,
            'title' => $this->title,
            'deadline' => $this->deadline,
            'status'=> $this->status,
            'allocator_email' => $this->whenPivotLoaded('task_user', function () {
                return $this->pivot->allocator_email;
            }),
            'last_assigned_user' => $this->last_assigned,
            'confirmer'=>$this->confirmer,
            'allocator'=>$this->TaskUser
        ];
    }
}
