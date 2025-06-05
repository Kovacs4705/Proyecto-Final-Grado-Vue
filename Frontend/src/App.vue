<!-- src/App.vue -->
<template>
  <!-- Solo muestro el navbar si NO estoy en la ruta “login” -->
  <Navbar v-if="currentRouteName !== 'login'" />

  <main>
    <router-view />
  </main>

  <!-- Solo muestro el footer si NO estoy en la ruta “login” -->
  <FooterGeneral v-if="currentRouteName !== 'login'" />
</template>

<script setup>
import { computed, onMounted, watch } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import AOS from 'aos'

import Navbar from './components/Navbar.vue'
import FooterGeneral from './components/Footer.vue'

const router = useRouter()
const route = useRoute()

// Computed que expone el nombre de la ruta activa
const currentRouteName = computed(() => route.name)

// Cuando cambie la ruta, forzar refresh de AOS (si lo usas para animaciones)
onMounted(() => {
  watch(
    () => route.fullPath,
    () => {
      AOS.refresh()
    }
  )
})
</script>

<style>
/* Nada aquí... */
</style>
