<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Fa\Database\FaMigration;

class CreateTasksTable extends FaMigration
{
  protected $tblName = 'tasks';

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create($this->tblName, function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onDelete('cascade');
      $table->foreignId('task_list_id')->constrained()->onDelete('cascade');
      $table->string('title', 100);
      $table->string('description', 1000)->default('');
      $table->timestamp('done_at')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists($this->tblName);
  }
}
