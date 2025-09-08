<?php

namespace Database\Seeders;

use App\Models\Career;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CareerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Career::insert([
            ['name' => 'Ingeniería Informatica', 'study_plan' => '2025', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ingeniería Bioquímica', 'study_plan' => '2025', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ingeniería Industrial', 'study_plan' => '2025', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ingeniería Agronomía', 'study_plan' => '2025', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ingeniería Administración', 'study_plan' => '2025', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ingeniería Electromecánica', 'study_plan' => '2025', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ingeniería Energías Renovables', 'study_plan' => '2025', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
