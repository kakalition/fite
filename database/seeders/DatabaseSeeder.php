<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    User::create([
      'name' => 'Admin',
      'email' => 'admin@fite.com',
      'password' => Hash::make('adminisright'),
      'authorization_code' => 2
    ]);
  }
}
