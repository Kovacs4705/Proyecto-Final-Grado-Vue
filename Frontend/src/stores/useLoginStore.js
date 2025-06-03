// src/stores/useLoginStore.js
import { defineStore } from 'pinia'

// import.meta.env.VITE_API_URL debe leerse aquí
const API_URL = import.meta.env.VITE_API_URL
console.log("🍍 API_URL =", API_URL)

export const useLoginStore = defineStore('login', {
  state: () => ({
    isLoading: false,
    error: null,
    user: null
  }),

  actions: {
    async registerUser(datosRegistro) {
      this.isLoading = true
      this.error = null

      try {
        // Si API_URL es undefined, esta línea hará fetch("undefined/registrar-usuario", …)
        const respuesta = await fetch(`${API_URL}/registrar-usuario`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            dni_usuario: datosRegistro.dni_usuario,
            nombre:      datosRegistro.nombre,
            email:       datosRegistro.email,
            contraseña:  datosRegistro.contraseña
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
        } catch { /* cuerpo vacío o no JSON */ }

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

    // (opcional) Si en el futuro quieres un login real:
    async loginUser(credenciales) {
      this.isLoading = true
      this.error = null

      try {
        const res = await fetch(`${API_URL}/login`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            email:      credenciales.email,
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
        this.user = data
        this.isLoading = false
        return true

      } catch (err) {
        console.error('Error en login:', err)
        this.error = 'Error de red o servidor'
        this.isLoading = false
        return false
      }
    }
  }
})
