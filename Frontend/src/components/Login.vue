<template>
    <div class="card p-4 shadow rounded bg-dark text-white" data-aos="fade-up">
      <h2 class="text-center mb-4">{{ isLogin ? 'Iniciar Sesión' : 'Registrarse' }}</h2>
  
      <form @submit.prevent="handleSubmit">
        <div class="mb-3">
          <label class="form-label">Correo electrónico</label>
          <input type="email" v-model="form.email" class="form-control" required />
        </div>
  
        <div class="mb-3">
          <label class="form-label">Contraseña</label>
          <input type="password" v-model="form.password" class="form-control" required />
        </div>
  
        <button class="btn btn-primary w-100" type="submit">
          {{ isLogin ? 'Entrar' : 'Registrarse' }}
        </button>
  
        <button class="btn btn-outline-light mt-3 w-100" type="button" @click="toggleMode">
          {{ isLogin ? '¿No tienes cuenta? Regístrate' : '¿Ya tienes cuenta? Inicia sesión' }}
        </button>
      </form>
  
      <div class="text-center mt-4">
        <span>O entra como:</span>
        <button class="btn btn-secondary mt-2 w-100" @click="entrarComoInvitado">Invitado</button>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import { useRouter } from 'vue-router'
  
  const emit = defineEmits(['logged-in'])
  const router = useRouter()
  const isLogin = ref(true)
  
  const form = ref({
    email: '',
    password: ''
  })
  
  function toggleMode() {
    isLogin.value = !isLogin.value
  }
  
  function handleSubmit() {
    if (isLogin.value) {
      if (form.value.email.includes('admin')) {
        emit('logged-in', 'admin')
      } else {
        emit('logged-in', 'usuario')
      }
    } else {
      alert('Registro completado. Ahora puedes iniciar sesión.')
      isLogin.value = true
    }
  }
  
  function entrarComoInvitado() {
    emit('logged-in', 'invitado')
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
  