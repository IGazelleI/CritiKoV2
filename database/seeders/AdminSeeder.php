<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create([
            'type' => 1,
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin')
        ]);

        Admin::create([
            'user_id' => $user->id
        ]);
    }
}
