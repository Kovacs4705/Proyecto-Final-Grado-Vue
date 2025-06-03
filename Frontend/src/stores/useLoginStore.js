// src/stores/useAuthStore.js
import { defineStore } from 'pinia'

const API_URL = import.meta.env.VITE_API_URL // por ejemplo: "http://192.168.1.45:3000/api"

export const useAuthStore = defineStore('auth', {
  state: () => ({
    isLoading: false,
    error: null
  }),

  actions: {
    /**
     * Llama al endpoint POST /api/registrar-usuario
     * @param {{ dni_usuario: string, nombre: string, email: string, contraseña: string }} datosRegistro
     * @returns {Promise<boolean>} true si el usuario se registró (201), false si hubo algún error
     */
    async registerUser(datosRegistro) {
      this.isLoading = true
      this.error = null

      try {
        const respuesta = await fetch(`${API_URL}/registrar-usuario`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            dni_usuario:  datosRegistro.dni_usuario,
            nombre:       datosRegistro.nombre,
            email:        datosRegistro.email,
            contraseña:   datosRegistro.contraseña
          })
        })

        if (respuesta.status === 201) {
          // Usuario registrado correctamente
          this.isLoading = false
          return true
        }

        // Si devuelve 422 (o cualquier otro error), leemos el mensaje
        const errJson = await respuesta.json()
        this.error = errJson.message || `Error ${respuesta.status}`
        this.isLoading = false
        return false

      } catch (err) {
        console.error('Error al registrar usuario:', err)
        this.error = 'Error de red o servidor'
        this.isLoading = false
        return false
      }
    }
  }
})
