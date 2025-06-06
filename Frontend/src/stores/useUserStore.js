// src/stores/useUsersStore.js
import { defineStore } from "pinia";

const API_URL = import.meta.env.VITE_API_URL_REAL;

export const useUsersStore = defineStore("users", {
    state: () => ({
        users: [], // lista de todos los usuarios
        userActual: null, // usuario seleccionado/consultado
        isLoadingList: false,
        isLoadingOne: false,
        isSubmitting: false,
        isDeleting: false,
        error: null,
    }),

    actions: {
        // GET /api/usuarios
        async fetchUsers({ pagina = 1, registrosPorPagina = 10 } = {}) {
            this.isLoadingList = true;
            this.error = null;

            try {
                const res = await fetch(
                    `${API_URL}/usuarios?pagina=${pagina}&registrosPorPagina=${registrosPorPagina}`
                );
                if (!res.ok)
                    throw new Error(`Error ${res.status} al cargar usuarios`);
                this.users = await res.json();
            } catch (err) {
                this.error =
                    err.message || "Error desconocido al cargar usuarios";
                this.users = [];
            } finally {
                this.isLoadingList = false;
            }
        },

        // GET /api/usuarios/{dni_usuario}
        async fetchUserByDni(dni) {
            this.isLoadingOne = true;
            this.error = null;

            try {
                const res = await fetch(
                    `${API_URL}/usuarios/${encodeURIComponent(dni)}`
                );
                if (res.status === 404)
                    throw new Error("Usuario no encontrado");
                if (!res.ok)
                    throw new Error(`Error ${res.status} al obtener usuario`);
                this.userActual = await res.json();
            } catch (err) {
                this.error =
                    err.message || "Error desconocido al obtener usuario";
                this.userActual = null;
            } finally {
                this.isLoadingOne = false;
            }
        },

        // POST /api/usuarios
        async createUser(payload) {
            this.isSubmitting = true;
            this.error = null;

            try {
                const res = await fetch(`${API_URL}/usuarios`, {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(payload),
                });
                if (res.status === 422) {
                    const errJson = await res.json().catch(() => ({}));
                    throw new Error(errJson.message || "Error de validación");
                }
                if (!res.ok)
                    throw new Error(`Error ${res.status} al crear usuario`);
                return await res.json();
            } catch (err) {
                this.error =
                    err.message || "Error desconocido al crear usuario";
                return null;
            } finally {
                this.isSubmitting = false;
            }
        },

        // PUT /api/usuarios/{dni_usuario}
        async updateUserByDni(dni, payload) {
            try {
                const res = await fetch(`${API_URL}/usuarios/${dni}`, {
                    method: "PUT",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(payload),
                });
                if (!res.ok) {
                    const data = await res.json();
                    // Guarda el mensaje de error para mostrarlo en el modal
                    this.error =
                        data.message || "Error al actualizar el usuario.";
                    return false;
                }
                this.error = null;
                return await res.json();
            } catch (e) {
                this.error = "Error de red o servidor.";
                return false;
            }
        },

        // DELETE /api/usuarios/{dni_usuario}
        async deleteUserByDni(dni) {
            this.isDeleting = true;
            this.error = null;

            try {
                const res = await fetch(
                    `${API_URL}/usuarios/${encodeURIComponent(dni)}`,
                    {
                        method: "DELETE",
                    }
                );
                if (res.status === 404)
                    throw new Error("Usuario no encontrado");
                if (!res.ok)
                    throw new Error(`Error ${res.status} al eliminar usuario`);
                return await res.json(); // p.ej. { "message": "Usuario eliminado correctamente" }
            } catch (err) {
                this.error =
                    err.message || "Error desconocido al eliminar usuario";
                return null;
            } finally {
                this.isDeleting = false;
            }
        },

        // GET /api/usuarios/buscarPorParametro?parametro=...
        async searchUsers(parametro) {
            this.isLoadingList = true;
            this.error = null;

            try {
                const res = await fetch(
                    `${API_URL}/usuarios/buscarPorParametro?parametro=${encodeURIComponent(
                        parametro
                    )}`
                );
                if (!res.ok)
                    throw new Error(`Error ${res.status} al buscar usuarios`);
                this.users = await res.json();
            } catch (err) {
                this.error =
                    err.message || "Error desconocido al buscar usuarios";
                this.users = [];
            } finally {
                this.isLoadingList = false;
            }
        },
    },
});
