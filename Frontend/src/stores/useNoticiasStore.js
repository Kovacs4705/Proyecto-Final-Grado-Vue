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
        if (!res.ok) throw new Error(`Error ${res.status} al cargar noticias`);
        this.noticias = await res.json();
      } catch (err) {
        this.error = err.message || "Error desconocido al cargar noticias";
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
        if (res.status === 404) throw new Error("Noticia no encontrada");
        if (!res.ok)
          throw new Error(`Error ${res.status} al obtener la noticia`);
        this.noticiaActual = await res.json();
      } catch (err) {
        this.error = err.message || "Error desconocido al obtener la noticia";
      } finally {
        this.isLoadingOne = false;
      }
    },

    // 3) POST /api/noticias
    async crearNoticia(payload) {
      this.isSubmitting = true;
      this.error = null;
      try {
        const res = await fetch(`${API_URL}/noticias`, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(payload),
        });
        if (res.status === 422) {
          const errJson = await res.json().catch(() => ({}));
          throw new Error(errJson.message || "Error de validación");
        }
        if (!res.ok) throw new Error(`Error ${res.status} al crear noticia`);
        return await res.json();
      } catch (err) {
        this.error = err.message || "Error desconocido al crear noticia";
        return null;
      } finally {
        this.isSubmitting = false;
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
        if (res.status === 404) throw new Error("Noticia no encontrada");
        if (!res.ok)
          throw new Error(`Error ${res.status} al actualizar noticia`);
        return await res.json();
      } catch (err) {
        this.error = err.message || "Error desconocido al actualizar noticia";
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
        if (res.status === 404) throw new Error("Noticia no encontrada");
        if (!res.ok) throw new Error(`Error ${res.status} al eliminar noticia`);
        return await res.json();
      } catch (err) {
        this.error = err.message || "Error desconocido al eliminar noticia";
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
          ? `data:${n.mime_type_portada || "image/jpeg"};base64,${n.portada}`
          : "",
        lightbox: n.lightbox
          ? `data:${n.mime_type_lightbox || "image/jpeg"};base64,${n.lightbox}`
          : "",
        title: n.titulo,
        description: n.descripcion,
        body: n.cuerpo,
      })),
    smallNews: (state) =>
      state.noticias.slice(3, 9).map((n) => ({
       image: n.portada
          ? `data:${n.mime_type_portada || "image/jpeg"};base64,${n.portada}`
          : "",
        lightbox: n.lightbox
          ? `data:${n.mime_type_lightbox || "image/jpeg"};base64,${n.lightbox}`
          : "",
        title: n.titulo,
        description: n.descripcion,
        body: n.cuerpo,
      })),
  },
});
