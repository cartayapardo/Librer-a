<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Se crean los roles de la aplicación
        Rol::create([
            'name' => 'Cliente',
        ]);

        Rol::create([
            'name' => 'Trabajador',
        ]);
    }
}
