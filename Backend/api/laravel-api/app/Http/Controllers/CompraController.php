<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Compra",
    description: "Operaciones relacionadas con las compras"
)]
class CompraController extends Controller
{
    #[OA\Get(
        path: "/api/compras",
        summary: "Listar todas las compras",
        tags: ["Compra"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de compras",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/Compra")
                )
            )
        ]
    )]
    public function index()
    {
        $compras = Compra::all();
        return response()->json($compras);
    }

    #[OA\Post(
        path: "/api/compras",
        summary: "Registrar una nueva compra",
        tags: ["Compra"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/CompraCreate")
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Compra registrada exitosamente",
                content: new OA\JsonContent(ref: "#/components/schemas/Compra")
            )
        ]
    )]
    public function store(Request $request)
    {
        $compra = Compra::create($request->all());
        return response()->json($compra, 201);
    }

    #[OA\Get(
        path: "/api/compras/{id}",
        summary: "Obtener una compra por ID",
        tags: ["Compra"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID de la compra",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Compra encontrada",
                content: new OA\JsonContent(ref: "#/components/schemas/Compra")
            ),
            new OA\Response(
                response: 404,
                description: "Compra no encontrada"
            )
        ]
    )]
    public function show(Compra $compra)
    {
        return response()->json($compra);
    }

    #[OA\Put(
        path: "/api/compras/{id}",
        summary: "Actualizar una compra existente",
        tags: ["Compra"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID de la compra",
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/CompraUpdate")
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Compra actualizada exitosamente",
                content: new OA\JsonContent(ref: "#/components/schemas/Compra")
            ),
            new OA\Response(
                response: 404,
                description: "Compra no encontrada"
            )
        ]
    )]
    public function update(Request $request, Compra $compra)
    {
        $compra->update($request->all());
        return response()->json($compra);
    }

    #[OA\Delete(
        path: "/api/compras/{id}",
        summary: "Eliminar una compra",
        tags: ["Compra"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID de la compra",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Compra eliminada correctamente",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Compra eliminada correctamente")
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: "Compra no encontrada"
            )
        ]
    )]
    public function destroy(Compra $compra)
    {
        $compra->delete();
        return response()->json(['message' => 'Compra eliminada correctamente']);
    }
}