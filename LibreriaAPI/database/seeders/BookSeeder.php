<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::create([
            'title' => 'El principito',
            'description' => 'Libro que describe la sociedad y su funcionamiento usando el viaje de un niño',
            'active' => 1
        ]);

        Book::create([
            'title' => 'Las mil y una noche',
            'description' => 'Una joven hace cuentos cada noche para no ser asesinada en la mañana',
            'active' => 1
        ]);

        Book::create([
            'title' => 'El viejo y el mar',
            'description' => 'La historia de  un viejo pescador',
            'active' => 1
        ]);
    }
}
