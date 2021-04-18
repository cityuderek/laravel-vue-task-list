<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaskList;

class TaskListSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->createTaskList(1, 2);
    $this->createTaskList(2, 2);
  }

  protected function createTaskList($userId, $n){
    for($i = 0; $i < $n; $i++){
      TaskList::create(
        [
          'title' => 'TaskList ' . ($i + 1),
          'description' => 'Description ' . rand(1000, 9999),
          'user_id' => $userId,
        ]
      );
    }
  }
}
