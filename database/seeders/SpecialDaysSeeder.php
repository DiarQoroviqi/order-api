<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialDaysSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('special_days')->insert([
            ['date' => now()->toDateString(), 'created_at' => now(), 'updated_at' => now()],
            ['date' => now()->addDays(1)->toDateString(), 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
