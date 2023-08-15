<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\School::create([
            'name' => 'STELLA MATUTINA Secondary school',
            'email' => 'stellamatutina@gmail.com',
            'password' => bcrypt('0788750979'),
        ]);
    }
}
