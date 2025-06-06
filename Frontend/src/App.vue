<!-- src/App.vue -->
<template>
  <Navbar v-if="currentRouteName !== 'login'" />
  <main>
    <router-view />
  </main>
  <FooterGeneral v-if="currentRouteName !== 'login'" />
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import AOS from 'aos'
import { useLoginStore } from './stores/useLoginStore.js'

import Navbar from './components/Navbar.vue'
import FooterGeneral from './components/Footer.vue'

const router    = useRouter()
const route     = useRoute()
const loginStore = useLoginStore()

// Si ya hay usuario logueado y estamos en /login, redirigimos a home
onMounted(() => {
  if (loginStore.user && route.name === 'login') {
    router.replace({ name: 'home' })
  }
  AOS.init()
})

// Computed que expone el nombre de la ruta activa
const currentRouteName = computed(() => route.name)
</script>

<style>
/* Nada aquí */
</style>
