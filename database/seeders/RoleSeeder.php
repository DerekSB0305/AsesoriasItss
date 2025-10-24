<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['role_type' => 'Ciencias basicas', 'created_at' => now(), 'updated_at' => now()],
            ['role_type' => 'Jefatura de division', 'created_at' => now(), 'updated_at' => now()],
            ['role_type' => 'Docente', 'created_at' => now(), 'updated_at' => now()],
            ['role_type' => 'Alumno', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
