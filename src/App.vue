<!-- src/App.vue -->
<template>
  <Navbar />
  <main>
    <router-view />
  </main>
  <Footer />

</template>

<script setup>
import { ref } from 'vue'
import Navbar from './components/Navbar.vue'
import Footer from './components/Footer.vue'

</script>

<style>
/* Nada aquí… */
</style>
