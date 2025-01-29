<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComputerSeeder extends Seeder
{
    public function run()
    {
        DB::table('computer')->insert([
            ['PCID' => 1, 'BüroNummer' => 101, 'created_at' => now(), 'updated_at' => now()],
            ['PCID' => 2, 'BüroNummer' => 102, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

