<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\TaskList;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    Task::truncate();
    TaskList::truncate();
    User::truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');
    $this->call(UserSeeder::class);
    $this->call(TaskListSeeder::class);
    $this->call(TaskSeeder::class);
  }
}
