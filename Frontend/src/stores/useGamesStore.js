import { defineStore } from "pinia";

const API_URL = import.meta.env.VITE_API_URL_REAL;

export const useGamesStore = defineStore("games", {
    state: () => ({
        games: [],
        gameActual: null,
        isLoadingList: false,
        isLoadingOne: false,
        isSubmitting: false,
        isDeleting: false,
        error: null,
    }),

    actions: {
        // GET /api/juegos
        async fetchGames({ pagina = 1, registrosPorPagina = 10 } = {}) {
            this.isLoadingList = true;
            this.error = null;
            try {
                const res = await fetch(
                    `${API_URL}/juegos?pagina=${pagina}&registrosPorPagina=${registrosPorPagina}`
                );
                if (!res.ok)
                    throw new Error(`Error ${res.status} al cargar juegos`);
                // La respuesta ya incluye generos y juego_imagens
                this.games = await res.json();
            } catch (err) {
                this.error =
                    err.message || "Error desconocido al cargar juegos";
                this.games = [];
            } finally {
                this.isLoadingList = false;
            }
        },

        // GET /api/juegos/{id}
        async fetchGamePorId(id) {
            this.isLoadingOne = true;
            this.error = null;
            try {
                const res = await fetch(`${API_URL}/juegos/${id}`);
                if (!res.ok) throw new Error("No encontrado");
                const data = await res.json();
                console.log("fetchGamePorId data:", data);
                
                // Opcional: this.gameActual = data
                data.imagenes = data.juego_imagens;
                return data;
            } catch (err) {
                this.error = err.message;
                return null;
            } finally {
                this.isLoadingOne = false;
            }
        },

        // POST /api/juegos
        async crearGame(payload) {
            this.isSubmitting = true;
            this.error = null;
            try {
                const res = await fetch(`${API_URL}/juegos`, {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(payload),
                });
                if (res.status === 422) {
                    const errJson = await res.json().catch(() => ({}));
                    throw new Error(errJson.message || "Error de validación");
                }
                if (!res.ok)
                    throw new Error(`Error ${res.status} al crear juego`);
                return await res.json();
            } catch (err) {
                this.error = err.message || "Error desconocido al crear juego";
                return null;
            } finally {
                this.isSubmitting = false;
            }
        },

        // PUT /api/juegos/{id}
        async actualizarGame(id, payload) {
            this.isSubmitting = true;
            this.error = null;
            try {
                const res = await fetch(`${API_URL}/juegos/${id}`, {
                    method: "PUT",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(payload),
                });
                if (res.status === 404) throw new Error("Juego no encontrado");
                if (!res.ok)
                    throw new Error(`Error ${res.status} al actualizar juego`);
                return await res.json();
            } catch (err) {
                this.error =
                    err.message || "Error desconocido al actualizar juego";
                return null;
            } finally {
                this.isSubmitting = false;
            }
        },

        // DELETE /api/juegos/{id}
        async eliminarGame(id) {
            this.isDeleting = true;
            this.error = null;
            try {
                const res = await fetch(`${API_URL}/juegos/${id}`, {
                    method: "DELETE",
                });
                if (res.status === 404) throw new Error("Juego no encontrado");
                if (!res.ok)
                    throw new Error(`Error ${res.status} al eliminar juego`);
                return await res.json();
            } catch (err) {
                this.error =
                    err.message || "Error desconocido al eliminar juego";
                return null;
            } finally {
                this.isDeleting = false;
            }
        },

        // GET /api/juegos/buscarPorParametro?parametro=...
        async buscarGamesPorParametro(parametro) {
            this.isLoadingList = true;
            this.error = null;
            try {
                const res = await fetch(
                    `${API_URL}/juegos/buscarPorParametro?parametro=${encodeURIComponent(
                        parametro
                    )}`
                );
                if (!res.ok)
                    throw new Error(`Error ${res.status} al buscar juegos`);
                this.games = await res.json();
            } catch (err) {
                this.error =
                    err.message || "Error desconocido al buscar juegos";
                this.games = [];
            } finally {
                this.isLoadingList = false;
            }
        },

        // GET /api/juegos/destacados
        async fetchGamesDestacados() {
            this.isLoadingList = true;
            this.error = null;
            try {
                const res = await fetch(`${API_URL}/juegos/destacados`);
                if (!res.ok)
                    throw new Error(
                        `Error ${res.status} al cargar juegos destacados`
                    );
                this.games = await res.json();
            } catch (err) {
                this.error =
                    err.message ||
                    "Error desconocido al cargar juegos destacados";
                this.games = [];
            } finally {
                this.isLoadingList = false;
            }
        },
    },
});
