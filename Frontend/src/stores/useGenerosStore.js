// src/stores/useGenresStore.js
import { defineStore } from 'pinia'

const API_URL = import.meta.env.VITE_API_URL_REAL

export const useGenresStore = defineStore('genres', {
  state: () => ({
    genres: [],         // lista paginada de géneros
    genreActual: null,  // género obtenido por su id
    isLoadingList: false,
    isLoadingOne: false,
    isSubmitting: false,
    isDeleting: false,
    error: null,
  }),

  actions: {
    // GET /api/generos?pagina=&registrosPorPagina=
    async fetchGenres({ pagina = 1, registrosPorPagina = 10 } = {}) {
      this.isLoadingList = true
      this.error = null

      try {
        const res = await fetch(
          `${API_URL}/generos?pagina=${pagina}&registrosPorPagina=${registrosPorPagina}`
        )
        if (!res.ok) throw new Error(`Error ${res.status} al cargar géneros`)
        this.genres = await res.json()
      } catch (err) {
        this.error = err.message || 'Error desconocido al cargar géneros'
        this.genres = []
      } finally {
        this.isLoadingList = false
      }
    },

    // GET /api/generos/{id}
    async fetchGenreById(id) {
      this.isLoadingOne = true
      this.error = null

      try {
        const res = await fetch(`${API_URL}/generos/${id}`)
        if (res.status === 404) throw new Error('Género no encontrado')
        if (!res.ok) throw new Error(`Error ${res.status} al obtener género`)
        this.genreActual = await res.json()
      } catch (err) {
        this.error = err.message || 'Error desconocido al obtener género'
        this.genreActual = null
      } finally {
        this.isLoadingOne = false
      }
    },

    // POST /api/generos
    async createGenre(payload) {
      this.isSubmitting = true
      this.error = null

      try {
        const res = await fetch(`${API_URL}/generos`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload),
        })
        if (res.status === 422) {
          const errJson = await res.json().catch(() => ({}))
          throw new Error(errJson.message || 'Error de validación')
        }
        if (!res.ok) throw new Error(`Error ${res.status} al crear género`)
        return await res.json()
      } catch (err) {
        this.error = err.message || 'Error desconocido al crear género'
        return null
      } finally {
        this.isSubmitting = false
      }
    },

    // PUT /api/generos/{id}
    async updateGenre(id, payload) {
      this.isSubmitting = true
      this.error = null

      try {
        const res = await fetch(`${API_URL}/generos/${id}`, {
          method: 'PUT',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload),
        })
        if (res.status === 404) throw new Error('Género no encontrado')
        if (!res.ok) throw new Error(`Error ${res.status} al actualizar género`)
        return await res.json()
      } catch (err) {
        this.error = err.message || 'Error desconocido al actualizar género'
        return null
      } finally {
        this.isSubmitting = false
      }
    },

    // DELETE /api/generos/{id}
    async deleteGenre(id) {
      this.isDeleting = true
      this.error = null

      try {
        const res = await fetch(`${API_URL}/generos/${id}`, {
          method: 'DELETE',
        })
        if (res.status === 404) throw new Error('Género no encontrado')
        if (!res.ok) throw new Error(`Error ${res.status} al eliminar género`)
        return await res.json() // p.ej. { message: "Género eliminado correctamente" }
      } catch (err) {
        this.error = err.message || 'Error desconocido al eliminar género'
        return null
      } finally {
        this.isDeleting = false
      }
    },
  },
})
