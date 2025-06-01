<?php

namespace App\Http\Controllers;

use App\Models\Resena;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Resena",
    description: "Operaciones relacionadas con las reseñas"
)]
class ResenaController extends Controller
{
    #[OA\Get(
        path: "/api/resenas",
        summary: "Listar todas las reseñas",
        tags: ["Resena"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de reseñas",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/Resena")
                )
            )
        ]
    )]
    public function index()
    {
        $resenas = Resena::all();
        return response()->json($resenas);
    }

    #[OA\Post(
        path: "/api/resenas",
        summary: "Crear una nueva reseña",
        tags: ["Resena"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/ResenaCreate")
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Reseña creada exitosamente",
                content: new OA\JsonContent(ref: "#/components/schemas/Resena")
            )
        ]
    )]
    public function store(Request $request)
    {
        $resena = Resena::create($request->all());
        return response()->json($resena, 201);
    }

    #[OA\Get(
        path: "/api/resenas/{id}",
        summary: "Obtener una reseña por ID",
        tags: ["Resena"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID de la reseña",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Reseña encontrada",
                content: new OA\JsonContent(ref: "#/components/schemas/Resena")
            ),
            new OA\Response(
                response: 404,
                description: "Reseña no encontrada"
            )
        ]
    )]
    public function show($id)
    {
        $resena = Resena::find($id);
        if (!$resena) {
            return response()->json(['message' => 'Reseña no encontrada'], 404);
        }
        return response()->json($resena);
    }

    #[OA\Put(
        path: "/api/resenas/{id}",
        summary: "Actualizar una reseña existente",
        tags: ["Resena"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID de la reseña",
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/ResenaUpdate")
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Reseña actualizada exitosamente",
                content: new OA\JsonContent(ref: "#/components/schemas/Resena")
            ),
            new OA\Response(
                response: 404,
                description: "Reseña no encontrada"
            )
        ]
    )]
    public function update(Request $request, $id)
    {
        $resena = Resena::find($id);
        if (!$resena) {
            return response()->json(['message' => 'Reseña no encontrada'], 404);
        }
        $resena->update($request->all());
        return response()->json($resena);
    }

    #[OA\Delete(
        path: "/api/resenas/{id}",
        summary: "Eliminar una reseña",
        tags: ["Resena"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID de la reseña",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Reseña eliminada correctamente",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Reseña eliminada correctamente")
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: "Reseña no encontrada"
            )
        ]
    )]
    public function destroy($id)
    {
        $resena = Resena::find($id);
        if (!$resena) {
            return response()->json(['message' => 'Reseña no encontrada'], 404);
        }
        $resena->delete();
        return response()->json(['message' => 'Reseña eliminada correctamente']);
    }
}