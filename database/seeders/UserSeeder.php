<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'User1',
            'role' => 'user',
            'email' => 'user@user.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123123123'),
            'status' => 'active',
            'approved' => True,
            'buero' => 'MZG 7.118',
            'SekretariatID' => 'sek001',
        ]);
    }
}
