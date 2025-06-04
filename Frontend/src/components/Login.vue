<!-- src/components/Login.vue -->
<template>
  <div class="card p-4 shadow rounded bg-dark text-white" data-aos="fade-up">
    <h2 class="text-center mb-4">
      {{ isLogin ? 'Iniciar Sesión' : 'Registrarse' }}
    </h2>

    <form @submit.prevent="handleSubmit">
      <!-- Campos adicionales solo en modo REGISTRARSE -->
      <div v-if="!isLogin" class="mb-3">
        <label class="form-label">DNI</label>
        <input
          type="text"
          v-model="form.dni_usuario"
          class="form-control"
          placeholder="12345678A"
          required
        />
      </div>

      <div v-if="!isLogin" class="mb-3">
        <label class="form-label">Nombre completo</label>
        <input
          type="text"
          v-model="form.nombre"
          class="form-control"
          placeholder="Juan Pérez"
          required
        />
      </div>

      <!-- Email (ambos modos) -->
      <div class="mb-3">
        <label class="form-label">Correo electrónico</label>
        <input
          type="email"
          v-model="form.email"
          class="form-control"
          placeholder="juan@ejemplo.com"
          required
        />
      </div>

      <!-- Contraseña (ambos modos) -->
      <div class="mb-3">
        <label class="form-label">Contraseña</label>
        <input
          type="password"
          v-model="form.password"
          class="form-control"
          placeholder="********"
          required
        />
      </div>

      <!-- Botón principal (Entrar / Registrarse) -->
      <button
        class="btn btn-primary w-100"
        type="submit"
        :disabled="loginStore.isLoading"
      >
        {{ loginStore.isLoading
          ? (isLogin ? 'Validando...' : 'Registrando...')
          : (isLogin ? 'Entrar' : 'Registrarse') }}
      </button>

      <!-- Toggle entre modos -->
      <button
        class="btn btn-outline-light mt-3 w-100"
        type="button"
        @click="toggleMode"
        :disabled="loginStore.isLoading"
      >
        {{ isLogin
          ? '¿No tienes cuenta? Regístrate'
          : '¿Ya tienes cuenta? Inicia sesión' }}
      </button>
    </form>

    <!-- Mostrar error (loginStore.error) -->
    <div v-if="loginStore.error" class="mt-3 alert alert-danger">
      {{ loginStore.error }}
    </div>

    <div class="text-center mt-4">
      <span>O entra como:</span>
      <button
        class="btn btn-secondary mt-2 w-100"
        @click="entrarComoInvitado"
        :disabled="loginStore.isLoading"
      >
        Invitado
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useLoginStore } from '../stores/useLoginStore.js'

const router     = useRouter()
const loginStore = useLoginStore()

const isLogin = ref(true)
const form    = ref({
  dni_usuario: '',
  nombre:      '',
  email:       '',
  password:    ''
})

function toggleMode() {
  loginStore.error = null
  isLogin.value = !isLogin.value
}

async function handleSubmit() {
  loginStore.error = null

  if (isLogin.value) {
    // -------------------------------
    // MODO INICIAR SESIÓN (real)
    // -------------------------------
    const ok = await loginStore.loginUser({
      email:       form.value.email.trim(),
      contraseña:  form.value.password
    })
    if (ok) {
      // Dependiendo del rol que guardó el store:
      const rolUsuario = loginStore.rol
      if (rolUsuario === 'admin') {
        router.push({ name: 'home-admin' })
      }
      else if (rolUsuario === 'usuario') {
        router.push({ name: 'home-usuario' })
      }
      else {
        // Si en tu backend existieran otros roles, o si no lo encontraron:
        router.push({ name: 'home-invitado' })
      }
    }
  }
  else {
    // -------------------------------
    // MODO REGISTRARSE
    // -------------------------------
    const payload = {
      dni_usuario: form.value.dni_usuario.trim(),
      nombre:      form.value.nombre.trim(),
      email:       form.value.email.trim(),
      contraseña:  form.value.password
    }

    const ok = await loginStore.registerUser(payload)
    if (ok) {
      alert('¡Registro completado! Ahora inicia sesión.')
      // Limpiar campos y volver a login
      form.value.dni_usuario = ''
      form.value.nombre      = ''
      form.value.email       = ''
      form.value.password    = ''
      isLogin.value = true
    }
    // Si ok === false, loginStore.error se mostrará
  }
}

function entrarComoInvitado() {
  // Simplemente navegamos a “home” sin llamar a loginStore.loginUser,
  // de modo que loginStore.user = null, rol = null → se mostrará la vista “invitado”.
  router.push({ name: 'home-invitado' })
}
</script>


<style scoped>
.card {
  background-color: #1c1c1c;
  border: none;
}
.form-control {
  background-color: #2c2c2c;
  color: white;
  border: 1px solid #555;
}
.form-control:focus {
  border-color: #0d6efd;
  box-shadow: none;
}
.btn-primary {
  background-color: #0d6efd;
  border: none;
}
.btn-secondary {
  background-color: #6c757d;
  border: none;
}
</style>
