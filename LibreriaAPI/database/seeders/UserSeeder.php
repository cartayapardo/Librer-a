<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Juan',
            'email' => 'juan@gmail.com',
            'password' => Hash::make('Pass2023Juan'),
            'lastname' => 'Castillo Reyes',
            'rol_id' => 2
        ]);

        User::create([
            'name' => 'Andrea',
            'email' => 'andrea@gmail.com',
            'password' => Hash::make('Pass2023Andrea'),
            'lastname' => 'Perez Nespral',
            'rol_id' => 2
        ]);

        User::create([
            'name' => 'Claudia',
            'email' => 'claudia@gmail.com',
            'password' => Hash::make('Pass2023Claudia'),
            'lastname' => 'Ramirez Paredes',
            'rol_id' => 2
        ]);
    }
}
