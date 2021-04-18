<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'title',
    'description',
    'user_id',
  ];

  public function user()
  {
      return $this->belongsTo(User::class);
  }

  public function taskList()
  {
      return $this->belongsTo(TaskList::class);
  }

  public static function setDone($task, $isDone)
  {
    if($isDone){
      $task->done_at = Carbon::now();
      $task->save();

    }else{
      $task->done_at = NULL;
      $task->save();
    }

    return true;
  }

  public static function getTasksStatistic($taskListId, $periodMinute = 60)
  {
    $periodSecond = $periodMinute * 60;
    // varDump($taskList, 'taskList');
    $now = Carbon::now();
    $startPeriodTime = $now->addSeconds(-$periodSecond);
    $count = Task::where('task_list_id', $taskListId)->where('created_at', '<=', $startPeriodTime)->count();
    $arr = [];
    for($i = 0; $i < $periodMinute; $i++){
      $arr[] = $count;
    }
    
    $tasksUpdatedWithinPeriod = Task::where('task_list_id', $taskListId)->where('created_at', '>', $startPeriodTime)
      ->orWhere('done_at', '>', $startPeriodTime)
      ->get();
    if($tasksUpdatedWithinPeriod){
      foreach($tasksUpdatedWithinPeriod as $task){
        $diffCreatedAt = $startPeriodTime->diffInMinutes($task->created_at);
        $diffDoneAt = $task->done_at ? $startPeriodTime->diffInMinutes($task->done_at) : NULL;
        logd("id=$task->id, diffCreatedAt=$diffCreatedAt, created_at=$task->created_at, diffDoneAt=$diffDoneAt, done_at=$task->done_at"); 
        if($diffCreatedAt < $periodMinute){
          for($i = $diffCreatedAt; $i < $periodMinute; $i++){
            $arr[$i]++;
          }
        }
        if($diffDoneAt !== NULL && $diffDoneAt < $periodMinute){
          for($i = $diffDoneAt; $i < $periodMinute; $i++){
            // logd("i=$i");
            $arr[$i]--;
          }
        }
      }
    }

    return $arr;
  }
}
