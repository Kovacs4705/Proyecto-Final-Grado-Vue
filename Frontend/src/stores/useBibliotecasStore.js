import { defineStore } from "pinia";
import { useLoginStore } from "./useLoginStore"; // Importa tu store de login

const API_URL = import.meta.env.VITE_API_URL_REAL;

export const useBibliotecasStore = defineStore("biblioteca", {
    state: () => ({
        biblioteca: [],
        bibliotecaActual: null,
        isLoadingList: false,
        isLoadingOne: false,
        isSubmitting: false,
        isDeleting: false,
        error: null,
    }),

    actions: {
        // GET /api/biblioteca
        async fetchBibliotecaUsuarioLogueado() {
            this.isLoadingList = true;
            this.error = null;
            try {
                const loginStore = useLoginStore();
                const dni_usuario = loginStore.user?.dni_usuario;
                console.log("DNI usuario:", dni_usuario);
                if (!dni_usuario) throw new Error("No hay usuario logueado");
                const res = await fetch(
                    `${API_URL}/biblioteca/usuario/${dni_usuario}`
                );
                const data = await res.json();
                console.log("Respuesta API:", data);
                if (!res.ok)
                    throw new Error(
                        `Error ${res.status} al cargar biblioteca del usuario`
                    );
                this.biblioteca = data;
            } catch (err) {
                this.error =
                    err.message ||
                    "Error desconocido al cargar biblioteca del usuario";
            } finally {
                this.isLoadingList = false;
            }
        },

        // GET /api/biblioteca/{id}
        async fetchBibliotecaPorId(id) {
            this.isLoadingOne = true;
            this.error = null;
            try {
                const res = await fetch(`${API_URL}/biblioteca/${id}`);
                if (res.status === 404)
                    throw new Error("Juego no encontrado en biblioteca");
                if (!res.ok)
                    throw new Error(
                        `Error ${res.status} al obtener juego de biblioteca`
                    );
                this.bibliotecaActual = await res.json();
            } catch (err) {
                this.error =
                    err.message ||
                    "Error desconocido al obtener juego de biblioteca";
            } finally {
                this.isLoadingOne = false;
            }
        },

        // GET /api/biblioteca/usuario/{dni_usuario}
        async fetchBibliotecaPorUsuario(dni_usuario) {
            this.isLoadingList = true;
            this.error = null;
            try {
                const res = await fetch(
                    `${API_URL}/biblioteca/usuario/${dni_usuario}`
                );
                if (!res.ok)
                    throw new Error(
                        `Error ${res.status} al cargar biblioteca del usuario`
                    );
                this.biblioteca = await res.json();
            } catch (err) {
                this.error =
                    err.message ||
                    "Error desconocido al cargar biblioteca del usuario";
            } finally {
                this.isLoadingList = false;
            }
        },

        // POST /api/biblioteca
        async agregarABiblioteca(payload) {
            this.isSubmitting = true;
            this.error = null;
            try {
                const res = await fetch(`${API_URL}/biblioteca`, {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(payload),
                });
                if (res.status === 422) {
                    const errJson = await res.json().catch(() => ({}));
                    throw new Error(errJson.message || "Error de validación");
                }
                if (!res.ok)
                    throw new Error(
                        `Error ${res.status} al agregar a biblioteca`
                    );
                return await res.json();
            } catch (err) {
                this.error =
                    err.message || "Error desconocido al agregar a biblioteca";
                return null;
            } finally {
                this.isSubmitting = false;
            }
        },

        // PUT /api/biblioteca/{id}
        async actualizarBiblioteca(id, payload) {
            this.isSubmitting = true;
            this.error = null;
            try {
                const res = await fetch(`${API_URL}/biblioteca/${id}`, {
                    method: "PUT",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(payload),
                });
                if (res.status === 404)
                    throw new Error("Juego no encontrado en biblioteca");
                if (!res.ok)
                    throw new Error(
                        `Error ${res.status} al actualizar biblioteca`
                    );
                return await res.json();
            } catch (err) {
                this.error =
                    err.message || "Error desconocido al actualizar biblioteca";
                return null;
            } finally {
                this.isSubmitting = false;
            }
        },

        // DELETE /api/biblioteca/{id}
        async eliminarDeBiblioteca(id) {
            this.isDeleting = true;
            this.error = null;
            try {
                const res = await fetch(`${API_URL}/biblioteca/${id}`, {
                    method: "DELETE",
                });
                if (res.status === 404)
                    throw new Error("Juego no encontrado en biblioteca");
                if (!res.ok)
                    throw new Error(
                        `Error ${res.status} al eliminar de biblioteca`
                    );
                return await res.json();
            } catch (err) {
                this.error =
                    err.message ||
                    "Error desconocido al eliminar de biblioteca";
                return null;
            } finally {
                this.isDeleting = false;
            }
        },
    },
});
