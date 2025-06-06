<!-- src/components/Login.vue -->
<template>
  <div class="card p-4 shadow rounded bg-dark text-white" data-aos="fade-up">
    <h2 class="text-center mb-4">
      {{ isLogin ? 'Iniciar Sesión' : 'Registrarse' }}
    </h2>

    <form @submit.prevent="handleSubmit">
      <!-- Campos de registro -->
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

      <!-- Campos comunes -->
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

      <!-- Botones -->
      <button
        class="btn btn-primary w-100"
        type="submit"
        :disabled="loginStore.isLoading"
      >
        {{ loginStore.isLoading
          ? (isLogin ? 'Validando...' : 'Registrando...')
          : (isLogin ? 'Entrar' : 'Registrarse') }}
      </button>
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

    <!-- Error display -->
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

const emit = defineEmits(['logged-in'])

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
    // MODO LOGIN
    const ok = await loginStore.loginUser({
      email:      form.value.email.trim(),
      contraseña: form.value.password
    })
    if (ok) {
      // Emitimos 'logged-in' con el rol para que LoginView lo capture
      // (loginStore.rol ya está seteado)
      const rolActual = loginStore.rol
      emit('logged-in', rolActual) 
      // Y redirigimos a home
      router.push({ name: 'home' })
    }
  }
  else {
    // MODO REGISTRO
    const payload = {
      dni_usuario: form.value.dni_usuario.trim(),
      nombre:      form.value.nombre.trim(),
      email:       form.value.email.trim(),
      contraseña:  form.value.password
    }

    const ok = await loginStore.registerUser(payload)
    if (ok) {
      alert('¡Registro completado! Ahora inicia sesión.')
      // Limpiar y volver a modo LOGIN
      form.value = { dni_usuario: '', nombre: '', email: '', password: '' }
      isLogin.value = true
    }
  }
}

function entrarComoInvitado() {
  // Vaciamos sesión (user queda null, rol null)
  loginStore.logout()
  emit('logged-in', null)
  router.push({ name: 'home' })
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
