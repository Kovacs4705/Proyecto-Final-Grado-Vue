<?php

namespace App\Http\Controllers;

use App\Models\JuegoGenero;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "JuegoGenero",
    description: "Operaciones relacionadas con la relación entre juegos y géneros"
)]
class JuegoGeneroController extends Controller
{
    #[OA\Get(
        path: "/api/juego-genero",
        summary: "Listar todas las relaciones entre juegos y géneros",
        tags: ["JuegoGenero"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de relaciones entre juegos y géneros",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/JuegoGenero")
                )
            )
        ]
    )]
    public function index()
    {
        $relaciones = JuegoGenero::all();
        return response()->json($relaciones);
    }

    #[OA\Post(
        path: "/api/juego-genero",
        summary: "Crear una nueva relación entre juego y género",
        tags: ["JuegoGenero"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/JuegoGeneroCreate")
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Relación creada exitosamente",
                content: new OA\JsonContent(ref: "#/components/schemas/JuegoGenero")
            )
        ]
    )]
    public function store(Request $request)
    {
        $relacion = JuegoGenero::create($request->all());
        return response()->json($relacion, 201);
    }

    #[OA\Get(
        path: "/api/juego-genero/{id}",
        summary: "Obtener una relación por ID",
        tags: ["JuegoGenero"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID de la relación",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Relación encontrada",
                content: new OA\JsonContent(ref: "#/components/schemas/JuegoGenero")
            ),
            new OA\Response(
                response: 404,
                description: "Relación no encontrada"
            )
        ]
    )]
    public function show($id)
    {
        $relacion = JuegoGenero::find($id);
        if (!$relacion) {
            return response()->json(['message' => 'Relación no encontrada'], 404);
        }
        return response()->json($relacion);
    }

    #[OA\Put(
        path: "/api/juego-genero/{id}",
        summary: "Actualizar una relación existente entre juego y género",
        tags: ["JuegoGenero"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID de la relación",
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/JuegoGeneroUpdate")
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Relación actualizada exitosamente",
                content: new OA\JsonContent(ref: "#/components/schemas/JuegoGenero")
            ),
            new OA\Response(
                response: 404,
                description: "Relación no encontrada"
            )
        ]
    )]
    public function update(Request $request, $id)
    {
        $relacion = JuegoGenero::find($id);
        if (!$relacion) {
            return response()->json(['message' => 'Relación no encontrada'], 404);
        }
        $relacion->update($request->all());
        return response()->json($relacion);
    }

    #[OA\Delete(
        path: "/api/juego-genero/{id}",
        summary: "Eliminar una relación entre juego y género",
        tags: ["JuegoGenero"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID de la relación",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Relación eliminada correctamente",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Relación eliminada correctamente")
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: "Relación no encontrada"
            )
        ]
    )]
    public function destroy($id)
    {
        $relacion = JuegoGenero::find($id);
        if (!$relacion) {
            return response()->json(['message' => 'Relación no encontrada'], 404);
        }
        $relacion->delete();
        return response()->json(['message' => 'Relación eliminada correctamente']);
    }
}