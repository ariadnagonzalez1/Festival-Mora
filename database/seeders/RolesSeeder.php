<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['nombre' => 'administrador']);
        Role::firstOrCreate(['nombre' => 'usuario']);
    }
}