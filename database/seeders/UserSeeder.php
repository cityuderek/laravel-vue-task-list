<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    User::create(
      [
        'name' => 'Derek Lam',
        'email' => 'dereklam306@gmail.com',
        'email_verified_at' => null,
        'password' => bcrypt('derek'),
        // 'is_admin' => 1,
      ]
    );
    User::create(
      [
        'name' => 'User 2',
        'email' => 'user2@gmail.com',
        'email_verified_at' => null,
        'password' => bcrypt('derek'),
      ]
    );
  }
}
