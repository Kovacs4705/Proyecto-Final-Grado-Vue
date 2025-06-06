<!-- src/views/LoginView.vue -->
<template>
  <div class="container login-container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <!-- El componente <Login> emitirá “logged-in” con el rol (o null para invitado) -->
        <Login @logged-in="redirigirUsuario" />
      </div>
    </div>
  </div>
</template>

<script setup>
import Login from '../components/Login.vue'
import { useRouter } from 'vue-router'
const router = useRouter()

function redirigirUsuario(rol) {
  // Aquí ya podemos redirigir a “home” o donde toque
  router.push({ name: 'home' })
}
</script>

<style scoped>
.login-container {
  margin-top: 100px;
}
</style>
