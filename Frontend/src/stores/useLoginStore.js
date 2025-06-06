// src/stores/useLoginStore.js
import { defineStore } from 'pinia'

// URL de tu API (reemplaza con la que tengas realmente definida)
const API_URL = import.meta.env.VITE_API_URL_REAL

export const useLoginStore = defineStore('login', {
  state: () => ({
    isLoading: false,
    error: null,
    // Si hay un "user" en localStorage, lo parseamos; si no, null
    user: JSON.parse(localStorage.getItem('usuario')) || null
  }),
  getters: {
    // Si user === null devuelve null, de lo contrario devuelve el rol
    rol: (state) => (state.user ? state.user.rol : null)
  },
  actions: {
    async registerUser(datosRegistro) {
      this.isLoading = true
      this.error = null

      try {
        const respuesta = await fetch(`${API_URL}/registrar-usuario`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            dni_usuario: datosRegistro.dni_usuario,
            nombre: datosRegistro.nombre,
            email: datosRegistro.email,
            contraseña: datosRegistro.contraseña
          })
        })

        if (respuesta.status === 201) {
          this.isLoading = false
          return true
        }

        let mensajeError = `Error ${respuesta.status}`
        try {
          const errJson = await respuesta.json()
          if (errJson.message) mensajeError = errJson.message
        } catch {}

        this.error = mensajeError
        this.isLoading = false
        return false
      } catch (err) {
        console.error('Error al registrar usuario:', err)
        this.error = 'Error de red o servidor'
        this.isLoading = false
        return false
      }
    },

    async loginUser(credenciales) {
      this.isLoading = true
      this.error = null

      try {
        const res = await fetch(`${API_URL}/login`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            email: credenciales.email,
            contraseña: credenciales.contraseña
          })
        })

        if (!res.ok) {
          let mensajeError = `Error ${res.status}`
          try {
            const errJson = await res.json()
            if (errJson.message) mensajeError = errJson.message
          } catch {}
          this.error = mensajeError
          this.isLoading = false
          return false
        }

        const data = await res.json()
        // data.usuario contiene el objeto usuario con rol, DNI, etc.
        this.user = data.usuario

        // Guarda en localStorage para persistirla tras refresh
        localStorage.setItem('usuario', JSON.stringify(data.usuario))

        this.isLoading = false
        return true
      } catch (err) {
        console.error('Error en login:', err)
        this.error = 'Error de red o servidor'
        this.isLoading = false
        return false
      }
    },

    logout() {
      // Limpia la sesión en el store y en localStorage
      this.user = null
      localStorage.removeItem('usuario')
    }
  }
})
