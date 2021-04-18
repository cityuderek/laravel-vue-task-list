<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class TaskResource extends JsonResource
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
        'task_list_id' => $this->task_list_id,
        'is_done' => !!$this->done_at,
        'createdAt' => $this->created_at->diffForHumans(),
      ];
    }
}
