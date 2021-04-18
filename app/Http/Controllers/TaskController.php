<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TaskResource;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use App\Models\TaskList;

class TaskController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $user = Auth::user();
    $tasks = Task::where('user_id', $user->id)->orderBy('title')->paginate(100);
    return TaskResource::collection($tasks);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  StoreTaskRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreTaskRequest $request)
  {
      $user = Auth::user();
      $taskList = TaskList::where('user_id', $user->id)->where('id', $request->task_list_id)->first();
      $this->checkUserTaskListPermission($user, $taskList);
      
      $task = new Task(['title' => $request->title, 'description' => $request->description, 'user_id' => $user->id]);
      // varDump($task, 'task');
      $taskList->tasks()->save($task);

      $tasks = Task::orderByDesc('created_at');
      return TaskResource::collection($tasks->get());
  }

  /**
   * Display the specified resource.
   *
   * @param  Task $task
   * @return \Illuminate\Http\Response
   */
  public function show(Task $task)
  {
    $user = Auth::user();
    $this->checkUserTaskPermission($user, $task);
    return new TaskResource($task);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  StoreTaskRequest  $request
   * @param  Task $task
   * @return \Illuminate\Http\Response
   */
  public function update(StoreTaskRequest $request, Task $task)
  {
    $user = Auth::user();
    $this->checkUserTaskPermission($user, $task);
    $data = $request->only(['title', 'description']);
    $status = $task->update($data);

    return response()->json([
        'status' => $status,
        'message' => $status ? 'Update Task Success' : 'Update Task Fail'
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  Task $task
   * @return \Illuminate\Http\Response
   */
  public function destroy(Task $task)
  {
    $user = Auth::user();
    $this->checkUserTaskPermission($user, $task);
    $status = $task->delete();

    return response()->json([
      'status' => $status,
      'message' => $status ? 'Task Deleted!' : 'Error Deleting Task'
    ]);
  }

  public function setDone($id, $value)
  {
    $isDone = $value === 'true';
    $task = Task::find($id);
    $user = Auth::user();
    $this->checkUserTaskPermission($user, $task);
    $status = Task::setDone($task, $isDone);

    return response()->json([
      'id' => $id,
      'isDone' => $isDone,
      'status' => $status,
      'message' => $status ? 'Set Task Done' : 'Error Set Task Done'
    ]);
  }
}
