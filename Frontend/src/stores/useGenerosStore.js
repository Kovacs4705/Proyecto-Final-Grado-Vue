import { defineStore } from "pinia";

const API_URL = import.meta.env.VITE_API_URL_REAL;

export const useGenerosStore = defineStore("generos", {
    state: () => ({
        genres: [], // lista paginada de géneros
        genreActual: null, // género obtenido por su id
        isLoadingList: false,
        isLoadingOne: false,
        isSubmitting: false,
        isDeleting: false,
        error: null,
    }),

    actions: {
        // GET /api/generos?pagina=&registrosPorPagina=
        async fetchGenres({ pagina = 1, registrosPorPagina = 10 } = {}) {
            this.isLoadingList = true;
            this.error = null;
            try {
                const res = await fetch(
                    `${API_URL}/generos?pagina=${pagina}&registrosPorPagina=${registrosPorPagina}`
                );
                if (!res.ok)
                    throw new Error(`Error ${res.status} al cargar géneros`);
                this.genres = await res.json();
            } catch (err) {
                this.error =
                    err.message || "Error desconocido al cargar géneros";
                this.genres = [];
            } finally {
                this.isLoadingList = false;
            }
        },

        // GET /api/generos/{id}
        async fetchGenreById(id) {
            this.isLoadingOne = true;
            this.error = null;
            try {
                const res = await fetch(`${API_URL}/generos/${id}`);
                if (res.status === 404) throw new Error("Género no encontrado");
                if (!res.ok)
                    throw new Error(`Error ${res.status} al obtener género`);
                const data = await res.json();
                console.log("fetchGenreById data:", data);
                this.genreActual = data;
                return data;
            } catch (err) {
                this.error =
                    err.message || "Error desconocido al obtener género";
                this.genreActual = null;
                return null;
            } finally {
                this.isLoadingOne = false;
            }
        },

        // POST /api/generos
        // payload: { nombre, imagen (File) }
        async createGenre(payload) {
            this.isSubmitting = true;
            this.error = null;
            try {
                console.log(`${API_URL}/generos`);
                
                const res = await fetch(`${API_URL}/generos`, {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(payload),
                });
                if (res.status === 422) {
                    const errJson = await res.json().catch(() => ({}));
                    throw new Error(errJson.message || "Error de validación");
                }
                if (!res.ok)
                    throw new Error(`Error ${res.status} al crear género`);
                return await res.json();
            } catch (err) {
                this.error = err.message || "Error desconocido al crear género";
                return null;
            } finally {
                this.isSubmitting = false;
            }
        },

        // PUT /api/generos/{id}
        // payload: { nombre, imagen (File) }
        async updateGenre(id, payload) {
            this.isSubmitting = true;
            this.error = null;
            try {
                const formData = new FormData();
                if (payload.nombre) formData.append("nombre", payload.nombre);
                if (payload.imagen) formData.append("imagen", payload.imagen);
                // Para Laravel: al usar FormData con PUT, se hace un POST + _method=PUT
                formData.append("_method", "PUT");
                const res = await fetch(`${API_URL}/generos/${id}`, {
                    method: "POST",
                    body: formData,
                    headers: { Accept: "application/json" },
                });
                console.log("updateGenre response:", res);
                
                if (res.status === 404) throw new Error("Género no encontrado");
                if (!res.ok)
                    throw new Error(`Error ${res.status} al actualizar género`);
                return await res.json();
            } catch (err) {
                this.error =
                    err.message || "Error desconocido al actualizar género";
                return null;
            } finally {
                this.isSubmitting = false;
            }
        },

        // DELETE /api/generos/{id}
        async deleteGenre(id) {
            this.isDeleting = true;
            this.error = null;
            try {
                const res = await fetch(`${API_URL}/generos/${id}`, {
                    method: "DELETE",
                });
                if (res.status === 404) throw new Error("Género no encontrado");
                if (!res.ok)
                    throw new Error(`Error ${res.status} al eliminar género`);
                return await res.json(); // p.ej. { message: "Género eliminado correctamente" }
            } catch (err) {
                this.error =
                    err.message || "Error desconocido al eliminar género";
                return null;
            } finally {
                this.isDeleting = false;
            }
        },
    },
});
