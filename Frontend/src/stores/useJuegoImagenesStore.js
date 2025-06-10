// src/stores/useJuegoImagenesStore.js
import { defineStore } from "pinia";

export const useJuegoImagenesStore = defineStore("juegoImagenes", {
    state: () => ({
        // Array donde guardaremos todas las imágenes de juegos
        imagenes: [],

        // Un objeto para guardar la imagen “actual” (para GET /api/juego-imagenes/{id})
        imagenActual: null,

        // Errores genéricos
        error: null,

        // Banderas de carga
        isLoadingList: false,
        isLoadingOne: false,
        isSubmitting: false,
        isDeleting: false,
    }),

    actions: {
        // ---------------------------
        // 1) GET /api/juego-imagenes
        // ---------------------------
        async fetchImagenes() {
            this.error = null;
            this.isLoadingList = true;
            try {
                const res = await fetch(
                    "http://localhost:8000/api/juego-imagenes"
                );
                if (!res.ok) {
                    throw new Error(`Error ${res.status} al cargar imágenes`);
                }
                const data = await res.json();
                // Supongamos que la respuesta es un array de objetos:
                // [{ id_imagen: 1, id_juego: 2, url: "...", descripcion: "..." }, ...]
                this.imagenes = data;
            } catch (err) {
                this.error =
                    err.message || "Error desconocido al cargar imágenes";
            } finally {
                this.isLoadingList = false;
            }
        },

        // ------------------------------------
        // 2) GET /api/juego-imagenes/{id}
        // ------------------------------------
        async fetchImagenPorId(id) {
            this.error = null;
            this.isLoadingOne = true;
            try {
                const res = await fetch(
                    `http://localhost:8000/api/juego-imagenes/${id}`
                );
                if (res.status === 404) {
                    throw new Error("Imagen no encontrada");
                }
                if (!res.ok) {
                    throw new Error(`Error ${res.status} al obtener la imagen`);
                }
                const data = await res.json();
                // data = { id_imagen: 1, id_juego: 2, url: "...", descripcion: "..." }
                this.imagenActual = data;
            } catch (err) {
                this.error =
                    err.message || "Error desconocido al obtener la imagen";
            } finally {
                this.isLoadingOne = false;
            }
        },

        // ------------------------------------
        // 3) POST /api/juego-imagenes
        // ------------------------------------
        // formData debe contener: id_juego, url, descripcion (o si envías multipart/form-data, ajusta en backend)
        async subirImagen(payload) {
            this.error = null;
            this.isSubmitting = true;
            try {
                const formData = new FormData();
                formData.append("id_juego", payload.id_juego);
                formData.append("categoria", payload.categoria);
                // Si tienes otros campos, agrégalos aquí
                if (payload.imagen instanceof File) {
                    formData.append("imagen", payload.imagen);
                } else if (typeof payload.imagen === "string") {
                    formData.append("imagen", payload.imagen);
                }

                const res = await fetch(
                    "http://localhost:8000/api/juego-imagenes",
                    {
                        method: "POST",
                        body: formData,
                        // No pongas Content-Type, fetch lo pone automáticamente para FormData
                    }
                );

                if (res.status === 422) {
                    const errJson = await res.json().catch(() => ({}));
                    const msg = errJson.errors
                        ? Object.values(errJson.errors).flat().join("; ")
                        : errJson.message || "Error de validación";
                    throw new Error(msg);
                }

                if (!res.ok) {
                    let textoError = "";
                    try {
                        const data = await res.json();
                        textoError = JSON.stringify(data, null, 2);
                    } catch {
                        textoError = await res.text().catch(() => "");
                    }
                    console.error("subirImagen Falló:", res.status, textoError);
                    throw new Error(
                        `Error ${res.status} al subir imagen: ${textoError}`
                    );
                }

                const nuevaImagen = await res.json();
                this.imagenes.push(nuevaImagen);
                return nuevaImagen;
            } catch (err) {
                this.error = err.message || "Error desconocido al subir imagen";
                return null;
            } finally {
                this.isSubmitting = false;
            }
        },

        // ------------------------------------
        // 4) PUT /api/juego-imagenes/{id}
        // ------------------------------------
        // payload sin id_imagen: { url, descripcion, id_juego } (según tu API)
        async actualizarImagen(id, payload) {
            this.error = null;
            this.isSubmitting = true;
            try {
                const res = await fetch(
                    `http://localhost:8000/api/juego-imagenes/${id}`,
                    {
                        method: "PUT",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify(payload),
                    }
                );
                if (res.status === 404) {
                    throw new Error("Imagen no encontrada para actualizar");
                }
                if (!res.ok) {
                    throw new Error(`Error ${res.status} al actualizar imagen`);
                }
                const imagenActualizada = await res.json();
                // Reemplazamos en el array la que tenía ese id
                const idx = this.imagenes.findIndex((i) => i.id_imagen === id);
                if (idx !== -1) {
                    this.imagenes.splice(idx, 1, imagenActualizada);
                }
                // Si tenemos cargada en memoria “imagenActual” y coincide:
                if (this.imagenActual && this.imagenActual.id_imagen === id) {
                    this.imagenActual = imagenActualizada;
                }
            } catch (err) {
                this.error =
                    err.message || "Error desconocido al actualizar imagen";
            } finally {
                this.isSubmitting = false;
            }
        },

        // ------------------------------------
        // 5) DELETE /api/juego-imagenes/{id}
        // ------------------------------------
        async eliminarImagen(id) {
            this.error = null;
            this.isDeleting = true;
            try {
                const res = await fetch(
                    `http://localhost:8000/api/juego-imagenes/${id}`,
                    {
                        method: "DELETE",
                    }
                );
                if (res.status === 404) {
                    throw new Error("Imagen no encontrada para eliminar");
                }
                if (!res.ok) {
                    throw new Error(`Error ${res.status} al eliminar imagen`);
                }
                // Respuesta típica: { message: "Imagen eliminada correctamente" }
                // Quitamos del array la que tiene ese id
                this.imagenes = this.imagenes.filter((i) => i.id_imagen !== id);
                // Si estaba cargada en “imagenActual”, la borramos
                if (this.imagenActual && this.imagenActual.id_imagen === id) {
                    this.imagenActual = null;
                }
            } catch (err) {
                this.error =
                    err.message || "Error desconocido al eliminar imagen";
            } finally {
                this.isDeleting = false;
            }
        },
    },
});
