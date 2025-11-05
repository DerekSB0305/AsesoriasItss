<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subjects')->insert([
            [
                'name' => 'Matemáticas Discretas',
                'career_id' => 1,
                'period' => '1er',
            ],
            [
                'name' => 'Cálculo Diferencial',
                'career_id' => 1,
                'period' => '1er',
            ],
            [
                'name' => 'Programación I',
                'career_id' => 1,
                'period' => '1er',
            ],
            [
                'name' => 'Base de Datos',
                'career_id' => 1,
                'period' => '2do',
            ],
            [
                'name' => 'Álgebra Lineal',
                'career_id' => 2,
                'period' => '1er',
            ],
        ]);
    }
}
