<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class ApiCategoriaController extends Controller
{
    // Método para obtener todas las categorías
    public function index()
    {
        try {
            // Recupera todas las categorías de la base de datos
            $categorias = Categoria::all();

            // Devuelve una respuesta JSON con código 200 OK
            return response()->json($categorias, 200);

        } catch (\Exception $e) {
            // Si ocurre un error, devuelve un mensaje con código 500
            return response()->json(['error' => 'Error al obtener las categorías', 'detalle' => $e->getMessage()], 500);
        }
    }

    // Método para almacenar una nueva categoría
    public function store(Request $request)
    {
        try {
            // Crea una nueva categoría con los datos recibidos
            $categoria = Categoria::create($request->only(['nombre', 'descripcion']));

            // Devuelve la categoría creada con código 201 Created
            return response()->json($categoria, 201);

        } catch (\Exception $e) {
            // Si ocurre un error, devuelve un mensaje con código 500
            return response()->json(['error' => 'Error al crear la categoría', 'detalle' => $e->getMessage()], 500);
        }
    }

    // Método para mostrar una categoría específica por ID
    public function show($id)
    {
        try {
            // Busca la categoría por su ID
            $categoria = Categoria::find($id);

            // Si no se encuentra, devuelve error 404
            if (!$categoria) {
                return response()->json(['error' => 'Categoría no encontrada'], 404);
            }

            // Devuelve la categoría encontrada
            return response()->json($categoria, 200);

        } catch (\Exception $e) {
            // Si ocurre un error, devuelve un mensaje con código 500
            return response()->json(['error' => 'Error al buscar la categoría', 'detalle' => $e->getMessage()], 500);
        }
    }

    // Método para actualizar una categoría existente
    public function update(Request $request, $id)
    {
        try {
            // Busca la categoría por ID
            $categoria = Categoria::find($id);

            // Si no se encuentra, devuelve error 404
            if (!$categoria) {
                return response()->json(['error' => 'Categoría no encontrada'], 404);
            }

            // Actualiza la categoría con los datos recibidos
            $categoria->update($request->only(['nombre', 'descripcion']));

            // Devuelve la categoría actualizada
            return response()->json($categoria, 200);

        } catch (\Exception $e) {
            // Si ocurre un error, devuelve un mensaje con código 500
            return response()->json(['error' => 'Error al actualizar la categoría', 'detalle' => $e->getMessage()], 500);
        }
    }

    // Método para eliminar una categoría
    public function destroy($id)
    {
        try {
            // Busca la categoría por ID
            $categoria = Categoria::find($id);

            // Si no se encuentra, devuelve error 404
            if (!$categoria) {
                return response()->json(['error' => 'Categoría no encontrada'], 404);
            }

            // Elimina la categoría
            $categoria->delete();

            // Devuelve mensaje de éxito
            return response()->json(['mensaje' => 'Categoría eliminada'], 200);

        } catch (\Exception $e) {
            // Si ocurre un error, devuelve un mensaje con código 500
            return response()->json(['error' => 'Error al eliminar la categoría', 'detalle' => $e->getMessage()], 500);
        }
    }
}
