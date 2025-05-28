<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Categorias;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Paso 5
        // Creo los datos de prueba para la tabla categorias
        Categoria::create([
            'nombre' => 'Electrónica',
            'descripcion' => 'Dispositivos electrónicos y gadgets.',
        ]);
        Categoria::create([
            'nombre' => 'Ropa',
            'descripcion' => 'Prendas de vestir y accesorios.',
        ]);
        Categoria::create([
            'nombre' => 'Alimentos',
            'descripcion' => 'Artículos para el hogar y alimentos.',
        ]);
        Categoria::create([
            'nombre' => 'Juguetes',
            'descripcion' => 'Juguetes y juegos para niños.',
        ]);
        Categoria::create([
            'nombre' => 'Deportes',
            'descripcion' => 'Equipamiento y ropa deportiva.',
        ]);
        Categoria::create([
            'nombre' => 'Libros',
            'descripcion' => 'Literatura y libros de texto.',
        ]);
        Categoria::create([
            'nombre' => 'Salud y Belleza',
            'descripcion' => 'Productos de cuidado personal y belleza.',
        ]);
    }
}
