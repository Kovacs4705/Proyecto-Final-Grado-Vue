<!-- src/App.vue -->
<template>
  <Navbar />
  <main class="pt-navbar">
    <router-view /> <!-- ← aquí se renderizará la vista activa -->
  </main>
  <Footer />
</template>

<script setup>
import Navbar from './components/Navbar.vue'
import Footer from './components/Footer.vue'
</script>

<style>
/* Nada aquí… */
</style>
