<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TaskListResource;
use App\Http\Requests\StoreTaskListRequest;
use App\Models\TaskList;
use App\Models\Task;

class TaskListController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $user = Auth::user();
    $taskLists = TaskList::where('user_id', $user->id)->orderBy('title')->paginate(100);
    return TaskListResource::collection($taskLists);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  StoreTaskListRequest $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreTaskListRequest $request)
  {
    $user = Auth::user();
    $taskList = new TaskList(['title' => $request->title, 'description' => $request->description]);
    $user->taskLists()->save($taskList);

    $taskLists = TaskList::orderByDesc('created_at');
    return TaskListResource::collection($taskLists->get());
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(TaskList $taskList)
  {
    $user = Auth::user();
    $this->checkUserTaskListPermission($user, $taskList);
    return new TaskListResource($taskList);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  StoreTaskListRequest  $request
   * @param  TaskList $taskList
   * @return \Illuminate\Http\Response
   */
  public function update(StoreTaskListRequest $request, TaskList $taskList)
  {
    $user = Auth::user();
    $this->checkUserTaskListPermission($user, $taskList);
    $status = $taskList->update(
        $request->only(['title', 'description'])
    );

    return response()->json([
        'status' => $status,
        'message' => $status ? 'Update Success' : 'Update Fail'
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  TaskList $taskList
   * @return \Illuminate\Http\Response
   */
  public function destroy(TaskList $taskList)
  {
    $user = Auth::user();
    $this->checkUserTaskListPermission($user, $taskList);
    $status = $taskList->delete();

    return response()->json([
      'status' => $status,
      'message' => $status ? 'Task List Deleted!' : 'Error Deleting Task List'
    ]);
  }

  public function getLastOneHourTaskStatistic($taskListId)
  {
    $taskList = TaskList::find($taskListId);
    $user = Auth::user();
    $this->checkUserTaskListPermission($user, $taskList);

    // varDump($taskList, 'taskList');
    $arr = Task::getTasksStatistic($taskListId, 60);
    
    return $arr;
  }
}
