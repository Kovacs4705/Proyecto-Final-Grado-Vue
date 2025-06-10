<?php


namespace App\Http\Controllers;

use App\Models\JuegoImagen;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Intervention\Image\ImageManager;

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
            content: new OA\MediaType(
                mediaType: "multipart/form-data",
                schema: new OA\Schema(
                    required: ["id_juego", "categoria", "imagen"],
                    properties: [
                        new OA\Property(property: "id_juego", type: "integer", example: 1),
                        new OA\Property(property: "categoria", type: "string", enum: ["horizontal", "vertical", "personaje"], example: "horizontal"),
                        new OA\Property(property: "imagen", type: "string", format: "binary"),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Imagen creada exitosamente",
                content: new OA\JsonContent(ref: "#/components/schemas/JuegoImagen")
            ),
            new OA\Response(
                response: 422,
                description: "Datos inválidos"
            ),
            new OA\Response(
                response: 500,
                description: "Error procesando la imagen"
            )
        ]
    )]
    public function store(Request $request)
    {
        $request->validate([
            'id_juego' => 'required|integer|exists:juego,id_juego',
            'categoria' => 'required|string|in:horizontal,vertical,personaje',
            'imagen' => 'required',
        ]);

        try {
            $manager = new ImageManager(new \Intervention\Image\Drivers\Gd\Driver());

            // Elegir dimensiones según la categoría
            $width = 800;
            $height = 400;
            switch ($request->input('categoria')) {
                case 'horizontal':
                    $width = 495;
                    $height = 302;
                    break;
                case 'vertical':
                    $width = 203;
                    $height = 261;
                    break;
                case 'personaje':
                    $width = 512;
                    $height = 512;
                    break;
            }

            $binario = null;
            if ($request->hasFile('imagen')) {
                $img = $manager->read($request->file('imagen')->getRealPath())->cover($width, $height);
                $binario = (string) $img->toJpeg();
            } elseif ($request->filled('imagen')) {
                $base64 = $request->input('imagen');
                if (preg_match('/^data:image\/(\w+);base64,/', $base64)) {
                    $base64 = substr($base64, strpos($base64, ',') + 1);
                }
                $img = $manager->read(base64_decode($base64))->cover($width, $height);
                $binario = (string) $img->toJpeg();
            } else {
                return response()->json(['message' => 'No se envió ninguna imagen'], 422);
            }

            $imagen = JuegoImagen::create([
                'id_juego' => $request->id_juego,
                'categoria' => $request->categoria,
                'imagen' => $binario,
            ]);

            return response()->json($imagen, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error procesando la imagen: ' . $e->getMessage()], 500);
        }
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
            content: new OA\MediaType(
                mediaType: "multipart/form-data",
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: "categoria", type: "string", enum: ["horizontal", "vertical", "personaje"], example: "horizontal"),
                        new OA\Property(property: "imagen", type: "string", format: "binary"),
                    ]
                )
            )
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

        // Si se actualiza la categoría, cambiarla y ajustar dimensiones
        $categoria = $request->input('categoria', $imagen->categoria);

        $width = 800;
        $height = 400;
        switch ($categoria) {
            case 'horizontal':
                $width = 495;
                $height = 302;
                break;
            case 'vertical':
                $width = 203;
                $height = 261;
                break;
            case 'personaje':
                $width = 512;
                $height = 512;
                break;
        }

        if ($request->has('categoria')) {
            $imagen->categoria = $categoria;
        }

        $manager = new ImageManager(new \Intervention\Image\Drivers\Gd\Driver());

        if ($request->hasFile('imagen')) {
            $img = $manager->read($request->file('imagen')->getRealPath())->cover($width, $height);
            $imagen->imagen = (string) $img->toJpeg();
        } elseif ($request->filled('imagen')) {
            $base64 = $request->input('imagen');
            if (preg_match('/^data:image\/(\w+);base64,/', $base64)) {
                $base64 = substr($base64, strpos($base64, ',') + 1);
            }
            $img = $manager->read(base64_decode($base64))->cover($width, $height);
            $imagen->imagen = (string) $img->toJpeg();
        }

        $imagen->save();

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
