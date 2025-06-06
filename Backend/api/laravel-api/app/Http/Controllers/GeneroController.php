<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Intervention\Image\ImageManager;

#[OA\Tag(
    name: "Genero",
    description: "Operaciones relacionadas con los géneros"
)]
class GeneroController extends Controller
{
    #[OA\Get(
        path: "/api/generos",
        summary: "Listar todos los géneros paginados",
        tags: ["Genero"],
        parameters: [
            new OA\Parameter(
                name: "pagina",
                in: "query",
                required: false,
                description: "Número de página",
                schema: new OA\Schema(type: "integer", default: 1)
            ),
            new OA\Parameter(
                name: "registrosPorPagina",
                in: "query",
                required: false,
                description: "Cantidad de registros por página",
                schema: new OA\Schema(type: "integer", default: 10)
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de géneros paginada",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "data", type: "array", items: new OA\Items(ref: "#/components/schemas/Genero")),
                    ]
                )
            )
        ]
    )]
    public function index(Request $request)
    {
        $pagina = $request->query('pagina', 1);
        $registrosPorPagina = $request->query('registrosPorPagina', 10);

        $generos = Genero::paginate($registrosPorPagina, ['*'], 'page', $pagina);

        // Devuelve la imagen como base64
        $generos->getCollection()->transform(function ($genero) {
            $genero->imagen = $genero->imagen ? base64_encode($genero->imagen) : null;
            return $genero;
        });

        return response()->json($generos->items());
    }

    #[OA\Post(
        path: "/api/generos",
        summary: "Crear un nuevo género",
        tags: ["Genero"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: "multipart/form-data",
                schema: new OA\Schema(
                    required: ["nombre"],
                    properties: [
                        new OA\Property(property: "nombre", type: "string"),
                        new OA\Property(property: "imagen", type: "string", format: "binary")
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Género creado exitosamente",
                content: new OA\JsonContent(ref: "#/components/schemas/Genero")
            )
        ]
    )]
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $binario = null;
        if ($request->hasFile('imagen')) {
            $manager = new ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
            $img = $manager->read($request->file('imagen')->getRealPath())->cover(295, 139);
            $binario = (string) $img->toJpeg();
        }

        $genero = Genero::create([
            'nombre' => $request->nombre,
            'imagen' => $binario,
        ]);

        // Devuelve la imagen como base64
        $genero->imagen = $genero->imagen ? base64_encode($genero->imagen) : null;

        return response()->json($genero, 201);
    }

    #[OA\Get(
        path: "/api/generos/{id}",
        summary: "Obtener un género por ID",
        tags: ["Genero"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID del género",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Género encontrado",
                content: new OA\JsonContent(ref: "#/components/schemas/Genero")
            ),
            new OA\Response(
                response: 404,
                description: "Género no encontrado"
            )
        ]
    )]
    public function show($id)
    {
        $genero = Genero::find($id);
        if (!$genero) {
            return response()->json(['message' => 'Género no encontrado'], 404);
        }
        $genero->imagen = $genero->imagen ? base64_encode($genero->imagen) : null;
        return response()->json($genero);
    }

    #[OA\Put(
        path: "/api/generos/{id}",
        summary: "Actualizar un género existente",
        tags: ["Genero"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID del género",
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: "multipart/form-data",
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: "nombre", type: "string"),
                        new OA\Property(property: "imagen", type: "string", format: "binary")
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Género actualizado exitosamente",
                content: new OA\JsonContent(ref: "#/components/schemas/Genero")
            ),
            new OA\Response(
                response: 404,
                description: "Género no encontrado"
            )
        ]
    )]
    public function update(Request $request, $id)
    {
        $genero = Genero::find($id);
        if (!$genero) {
            return response()->json(['message' => 'Género no encontrado'], 404);
        }

        if ($request->has('nombre')) {
            $genero->nombre = $request->nombre;
        }

        if ($request->hasFile('imagen')) {
            $manager = new ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
            $img = $manager->read($request->file('imagen')->getRealPath())->cover(295, 139);
            $genero->imagen = (string) $img->toJpeg();
        }

        $genero->save();

        $genero->imagen = $genero->imagen ? base64_encode($genero->imagen) : null;
        return response()->json($genero);
    }

    #[OA\Delete(
        path: "/api/generos/{id}",
        summary: "Eliminar un género",
        tags: ["Genero"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID del género",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Género eliminado correctamente",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "Género eliminado correctamente")
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: "Género no encontrado"
            )
        ]
    )]
    public function destroy($id)
    {
        $genero = Genero::find($id);
        if (!$genero) {
            return response()->json(['message' => 'Género no encontrado'], 404);
        }
        $genero->delete();
        return response()->json(['message' => 'Género eliminado correctamente']);
    }
}