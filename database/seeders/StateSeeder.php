<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('states')->insert([
            ['name' => 'Damascus'],
            ['name' => 'Rif Dimashq'],
            ['name' => 'Aleppo'],
            ['name' => 'Homs'],
            ['name' => 'Latakia'],
            ['name' => 'Hama'],
            ['name' => 'Tartus'],
            ['name' => 'Daraa'],
            ['name' => 'Al Suwayda'],
        ]);
    }
}
