<?php

namespace App\Http\Controllers;

use App\Models\UsuarioLogro;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "UsuarioLogro",
    description: "Operaciones relacionadas con la relación entre usuarios y logros"
)]
class UsuarioLogroController extends Controller
{
    #[OA\Get(
        path: "/api/usuario-logros",
        summary: "Listar todas las relaciones entre usuarios y logros",
        tags: ["UsuarioLogro"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de relaciones entre usuarios y logros",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/UsuarioLogro")
                )
            )
        ]
    )]
    public function index()
    {
        $relaciones = UsuarioLogro::all();
        return response()->json($relaciones);
    }

    #[OA\Post(
        path: "/api/usuario-logros",
        summary: "Crear una nueva relación entre usuario y logro",
        tags: ["UsuarioLogro"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/UsuarioLogroCreate")
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Relación creada exitosamente",
                content: new OA\JsonContent(ref: "#/components/schemas/UsuarioLogro")
            )
        ]
    )]
    public function store(Request $request)
    {
        $relacion = UsuarioLogro::create($request->all());
        return response()->json($relacion, 201);
    }

    #[OA\Get(
        path: "/api/usuario-logros/{id}",
        summary: "Obtener una relación por ID",
        tags: ["UsuarioLogro"],
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
                content: new OA\JsonContent(ref: "#/components/schemas/UsuarioLogro")
            ),
            new OA\Response(
                response: 404,
                description: "Relación no encontrada"
            )
        ]
    )]
    public function show($id)
    {
        $relacion = UsuarioLogro::find($id);
        if (!$relacion) {
            return response()->json(['message' => 'Relación no encontrada'], 404);
        }
        return response()->json($relacion);
    }

    #[OA\Put(
        path: "/api/usuario-logros/{id}",
        summary: "Actualizar una relación existente entre usuario y logro",
        tags: ["UsuarioLogro"],
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
            content: new OA\JsonContent(ref: "#/components/schemas/UsuarioLogroUpdate")
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Relación actualizada exitosamente",
                content: new OA\JsonContent(ref: "#/components/schemas/UsuarioLogro")
            ),
            new OA\Response(
                response: 404,
                description: "Relación no encontrada"
            )
        ]
    )]
    public function update(Request $request, $id)
    {
        $relacion = UsuarioLogro::find($id);
        if (!$relacion) {
            return response()->json(['message' => 'Relación no encontrada'], 404);
        }
        $relacion->update($request->all());
        return response()->json($relacion);
    }

    #[OA\Delete(
        path: "/api/usuario-logros/{id}",
        summary: "Eliminar una relación entre usuario y logro",
        tags: ["UsuarioLogro"],
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
        $relacion = UsuarioLogro::find($id);
        if (!$relacion) {
            return response()->json(['message' => 'Relación no encontrada'], 404);
        }
        $relacion->delete();
        return response()->json(['message' => 'Relación eliminada correctamente']);
    }
}