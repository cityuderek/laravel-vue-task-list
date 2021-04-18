<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Task;
use App\Models\TaskList;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function checkUserTaskPermission($user, $task){
      if($user->id != $task->user_id){
        throw new \Exception("No access");
      }
    }

    protected function checkUserTaskListPermission($user, $taskList){
      if($user->id != $taskList->user_id){
        throw new \Exception("No access");
      }
    }
}
