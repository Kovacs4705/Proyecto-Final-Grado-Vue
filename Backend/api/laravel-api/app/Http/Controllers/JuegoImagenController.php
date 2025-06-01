<?php


namespace App\Http\Controllers;

use App\Models\JuegoImagen;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "JuegoImagen",
    description: "Operaciones relacionadas con las imágenes de los juegos"
)]
class JuegoImagenController extends Controller
{
    #[OA\Get(
        path: "/api/juego-imagenes",
        summary: "Listar todas las imágenes de los juegos",
        tags: ["JuegoImagen"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de imágenes de los juegos",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/JuegoImagen")
                )
            )
        ]
    )]
    public function index()
    {
        $imagenes = JuegoImagen::all();
        return response()->json($imagenes);
    }

    #[OA\Post(
        path: "/api/juego-imagenes",
        summary: "Crear una nueva imagen para un juego",
        tags: ["JuegoImagen"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/JuegoImagenCreate")
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Imagen creada exitosamente",
                content: new OA\JsonContent(ref: "#/components/schemas/JuegoImagen")
            )
        ]
    )]
    public function store(Request $request)
    {
        $imagen = JuegoImagen::create($request->all());
        return response()->json($imagen, 201);
    }

    #[OA\Get(
        path: "/api/juego-imagenes/{id}",
        summary: "Obtener una imagen por ID",
        tags: ["JuegoImagen"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID de la imagen",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Imagen encontrada",
                content: new OA\JsonContent(ref: "#/components/schemas/JuegoImagen")
            ),
            new OA\Response(
                response: 404,
                description: "Imagen no encontrada"
            )
        ]
    )]
    public function show($id)
    {
        $imagen = JuegoImagen::find($id);
        if (!$imagen) {
            return response()->json(['message' => 'Imagen no encontrada'], 404);
        }
        return response()->json($imagen);
    }

    #[OA\Put(
        path: "/api/juego-imagenes/{id}",
        summary: "Actualizar una imagen existente",
        tags: ["JuegoImagen"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID de la imagen",
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/JuegoImagenUpdate")
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Imagen actualizada exitosamente",
                content: new OA\JsonContent(ref: "#/components/schemas/JuegoImagen")
            ),
            new OA\Response(
                response: 404,
                description: "Imagen no encontrada"
            )
        ]
    )]
    public function update(Request $request, $id)
    {
        $imagen = JuegoImagen::find($id);
        if (!$imagen) {
            return response()->json(['message' => 'Imagen no encontrada'], 404);
        }
        $imagen->update($request->all());
        return response()->json($imagen);
    }

    #[OA\Delete(
        path: "/api/juego-imagenes/{id}",
        summary: "Eliminar una imagen de un juego",
        tags: ["JuegoImagen"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID de la imagen",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Imagen eliminada correctamente",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Imagen eliminada correctamente")
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: "Imagen no encontrada"
            )
        ]
    )]
    public function destroy($id)
    {
        $imagen = JuegoImagen::find($id);
        if (!$imagen) {
            return response()->json(['message' => 'Imagen no encontrada'], 404);
        }
        $imagen->delete();
        return response()->json(['message' => 'Imagen eliminada correctamente']);
    }
}