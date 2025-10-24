<?php

namespace Database\Seeders;

use App\Models\Administrative;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ScienceDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { {
            $admin = Administrative::create([
                'administrative_user' => 'AlvaroEmir',
                'name' => 'Alvaro',
                'last_name_f' => 'Martinez',
                'last_name_m' => 'Aguilar',
                'position' => 'Jefe de Área',
            ]);

            User::create([
                'user' => $admin->administrative_user,
                'password' => Hash::make('12345678'),
                'role_id' => 1, // Ciencias Básicas
            ]);
        }
    }
}
