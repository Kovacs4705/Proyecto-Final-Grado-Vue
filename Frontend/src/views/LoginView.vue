<template>
    <div class="container login-container">
      <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
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
    if (rol === 'admin') {
      router.push('/admin')
    } else if (rol === 'usuario') {
      router.push('/usuario')
    } else {
      router.push('/invitado')
    }
  }
  </script>
  
  <style scoped>
  .login-container {
    margin-top: 100px;
  }
  </style>
  