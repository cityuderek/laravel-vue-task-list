<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->createTask(1, 1, 5);
    $this->createTask(1, 2, 4);
    $this->createTask(2, 3, 3);
    $this->createTask(2, 4, 2);
  }

  protected function createTask($userId, $taskListId, $n){
    for($i = 0; $i < $n; $i++){
      $data = 
      [
        'title' => 'Task ' . ($i + 1),
        'description' => 'Description ' . rand(1000, 9999),
        'user_id' => $userId,
        'task_list_id' => $taskListId,
        'created_at' => Carbon::createFromTimestamp(time() - $i * 1800),
      ];
      if($i == 4){
        $data['done_at'] = Carbon::createFromTimestamp(time() - 2 * 60);
      }
      // varDump($data, 'Task');
      Task::create($data);
    }
  }
}
