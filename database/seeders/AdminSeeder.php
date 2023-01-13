<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use App\Models\Period;
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
            'email' => 'admin@ctu.edu.ph',
            'password' => bcrypt('admin')
        ]);

        Admin::create([
            'user_id' => $user->id
        ]);

        Period::create([
            'semester' => 1,
            'begin' => NOW(),
            'end' => NOW()->addMonths(6)
        ]);
    }
}
