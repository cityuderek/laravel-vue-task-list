<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class TaskListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      return [
        'id' => $this->id,
        'title' => $this->title,
        'description' => $this->description,
        'user_id' => $this->user_id,
        'createdAt' => $this->created_at->format('Y-m-d H:i:s'),
        'tasks' => TaskResource::collection($this->tasks()->get()),
        'taskCount' => $this->tasks()->count(),
      ];
    }
}
