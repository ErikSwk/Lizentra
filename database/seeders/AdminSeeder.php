<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'role' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123123123'),
            'status' => 'active',
            'approved' => True,
            'buero' => 'MZG 7.118',
        ]);

        User::create([
            'name' => 'Admin2',
            'role' => 'admin',
            'email' => 'admin2@admin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123123123'),
            'status' => 'active',
            'approved' => True,
            'buero' => 'MZG 7.118',
        ]);
    }
}
