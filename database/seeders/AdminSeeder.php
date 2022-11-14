<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
            'user_id' => $user->id,
            'created_at' => NOW(),
            'updated_at' => NOW()
        ]);
    }
}
