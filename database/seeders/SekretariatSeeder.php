<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Sekretariat;

class SekretariatSeeder extends Seeder
{
    public function run()
    {
        Sekretariat::create([
            'SekretariatID' => 'sek001',
            'Lehrstuhl' => 'Schuhmann',
            'Email' => 'schuhmann@uni.de',
            'Fakultät' => 'WiWi',
        ]);
    }
}