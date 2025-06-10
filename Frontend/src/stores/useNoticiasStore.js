import { defineStore } from "pinia";

const API_URL = import.meta.env.VITE_API_URL_REAL;

export const useNoticiasStore = defineStore("noticias", {
    state: () => ({
        noticias: [],
        noticiaActual: null,
        isLoadingList: false,
        isLoadingOne: false,
        isSubmitting: false,
        isDeleting: false,
        error: null,
    }),

    actions: {
        // 1) GET /api/noticias?pagina=&registrosPorPagina=
        async fetchNoticias({ pagina = 1, registrosPorPagina = 10 } = {}) {
            this.isLoadingList = true;
            this.error = null;
            try {
                const res = await fetch(
                    `${API_URL}/noticias?pagina=${pagina}&registrosPorPagina=${registrosPorPagina}`
                );
                if (!res.ok)
                    throw new Error(`Error ${res.status} al cargar noticias`);
                this.noticias = await res.json();
            } catch (err) {
                this.error =
                    err.message || "Error desconocido al cargar noticias";
            } finally {
                this.isLoadingList = false;
            }
        },

        // 2) GET /api/noticias/{id}
        async fetchNoticiaPorId(id) {
            this.isLoadingOne = true;
            this.error = null;
            try {
                const res = await fetch(`${API_URL}/noticias/${id}`);
                if (res.status === 404)
                    throw new Error("Noticia no encontrada");
                if (!res.ok)
                    throw new Error(
                        `Error ${res.status} al obtener la noticia`
                    );
                const data = await res.json();
                console.log("fetchNoticiaPorId data:", data);
                
                this.noticiaActual = data;
                return data; // <-- Añade este return
            } catch (err) {
                this.error =
                    err.message || "Error desconocido al obtener la noticia";
                return null; // <-- Añade este return
            } finally {
                this.isLoadingOne = false;
            }
        },

        // 3) POST /api/noticias
        async crearNoticiaConArchivoJSON(payload) {
            this.isLoading = true;
            this.error = null;

            try {
                const res = await fetch(`${API_URL}/noticias`, {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(payload),
                });

                if (!res.ok) {
                    let msg = `Error ${res.status}`;
                    try {
                        const errJson = await res.json();
                        if (errJson.message) msg = errJson.message;
                    } catch {}
                    this.error = msg;
                    this.isLoading = false;
                    return null;
                }

                const data = await res.json();
                // Agregar al principio (opcional)
                this.noticias.unshift(data);
                this.isLoading = false;
                return data;
            } catch (err) {
                console.error("Error al crear noticia:", err);
                this.error = "Error de red o servidor";
                this.isLoading = false;
                return null;
            }
        },

        // 4) PUT /api/noticias/{id}
        async actualizarNoticia(id, payload) {
            this.isSubmitting = true;
            this.error = null;
            try {
                const res = await fetch(`${API_URL}/noticias/${id}`, {
                    method: "PUT",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(payload),
                });
                if (res.status === 404)
                    throw new Error("Noticia no encontrada");
                if (!res.ok)
                    throw new Error(
                        `Error ${res.status} al actualizar noticia`
                    );
                return await res.json();
            } catch (err) {
                this.error =
                    err.message || "Error desconocido al actualizar noticia";
                return null;
            } finally {
                this.isSubmitting = false;
            }
        },

        // 5) DELETE /api/noticias/{id}
        async eliminarNoticia(id) {
            this.isDeleting = true;
            this.error = null;
            try {
                const res = await fetch(`${API_URL}/noticias/${id}`, {
                    method: "DELETE",
                });
                if (res.status === 404)
                    throw new Error("Noticia no encontrada");
                if (!res.ok)
                    throw new Error(`Error ${res.status} al eliminar noticia`);
                return await res.json();
            } catch (err) {
                this.error =
                    err.message || "Error desconocido al eliminar noticia";
                return null;
            } finally {
                this.isDeleting = false;
            }
        },
    },
    getters: {
        featuredNews: (state) =>
            state.noticias.slice(0, 3).map((n) => ({
                image: n.portada
                    ? `data:${n.mime_type_portada || "image/jpeg"};base64,${
                          n.portada
                      }`
                    : "",
                lightbox: n.lightbox
                    ? `data:${n.mime_type_lightbox || "image/jpeg"};base64,${
                          n.lightbox
                      }`
                    : "",
                title: n.titulo,
                description: n.descripcion,
                body: n.cuerpo,
            })),
        smallNews: (state) =>
            state.noticias.slice(3, 9).map((n) => ({
                image: n.portada
                    ? `data:${n.mime_type_portada || "image/jpeg"};base64,${
                          n.portada
                      }`
                    : "",
                lightbox: n.lightbox
                    ? `data:${n.mime_type_lightbox || "image/jpeg"};base64,${
                          n.lightbox
                      }`
                    : "",
                title: n.titulo,
                description: n.descripcion,
                body: n.cuerpo,
            })),
    },
});
