<?php


namespace App\Http\Controllers;

use App\Models\Logro;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Logro",
    description: "Operaciones relacionadas con los logros"
)]
class LogroController extends Controller
{
    #[OA\Get(
        path: "/api/logros",
        summary: "Listar todos los logros",
        tags: ["Logro"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de logros",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/Logro")
                )
            )
        ]
    )]
    public function index()
    {
        $logros = Logro::all();
        return response()->json($logros);
    }

    #[OA\Post(
        path: "/api/logros",
        summary: "Crear un nuevo logro",
        tags: ["Logro"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/LogroCreate")
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Logro creado exitosamente",
                content: new OA\JsonContent(ref: "#/components/schemas/Logro")
            )
        ]
    )]
    public function store(Request $request)
    {
        $logro = Logro::create($request->all());
        return response()->json($logro, 201);
    }

    #[OA\Get(
        path: "/api/logros/{id}",
        summary: "Obtener un logro por ID",
        tags: ["Logro"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID del logro",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Logro encontrado",
                content: new OA\JsonContent(ref: "#/components/schemas/Logro")
            ),
            new OA\Response(
                response: 404,
                description: "Logro no encontrado"
            )
        ]
    )]
    public function show($id)
    {
        $logro = Logro::find($id);
        if (!$logro) {
            return response()->json(['message' => 'Logro no encontrado'], 404);
        }
        return response()->json($logro);
    }

    #[OA\Put(
        path: "/api/logros/{id}",
        summary: "Actualizar un logro existente",
        tags: ["Logro"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID del logro",
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/LogroUpdate")
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Logro actualizado exitosamente",
                content: new OA\JsonContent(ref: "#/components/schemas/Logro")
            ),
            new OA\Response(
                response: 404,
                description: "Logro no encontrado"
            )
        ]
    )]
    public function update(Request $request, $id)
    {
        $logro = Logro::find($id);
        if (!$logro) {
            return response()->json(['message' => 'Logro no encontrado'], 404);
        }
        $logro->update($request->all());
        return response()->json($logro);
    }

    #[OA\Delete(
        path: "/api/logros/{id}",
        summary: "Eliminar un logro",
        tags: ["Logro"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID del logro",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Logro eliminado correctamente",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Logro eliminado correctamente")
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: "Logro no encontrado"
            )
        ]
    )]
    public function destroy($id)
    {
        $logro = Logro::find($id);
        if (!$logro) {
            return response()->json(['message' => 'Logro no encontrado'], 404);
        }
        $logro->delete();
        return response()->json(['message' => 'Logro eliminado correctamente']);
    }
}