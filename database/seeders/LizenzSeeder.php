<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LizenzSeeder extends Seeder
{
    public function run()
    {
        // Beispiel-Daten einfügen
        DB::table('lizenz')->insert([
            [
                'LizenzID' => Str::random(8),
                'Lizenzbeginn' => '2024-12-01',
                'Lizenzende' => '2026-12-01',
                'Software' => 'MS Access',
                'Lizenzstatus' => 'active',
                'PCID' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'LizenzID' => Str::random(8),
                'Lizenzbeginn' => '2025-01-01',
                'Lizenzende' => '2027-01-01',
                'Software' => 'Adobe Photoshop',
                'Lizenzstatus' => 'inactive',
                'PCID' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
