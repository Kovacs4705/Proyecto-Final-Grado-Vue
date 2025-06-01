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
import { onMounted, watch } from 'vue'
import { useRouter } from 'vue-router'
import AOS from 'aos'

const router = useRouter()

onMounted(() => {
  watch(() => router.currentRoute.value.fullPath, () => {
    AOS.refresh()
  })
})

</script>

<style>
/* Nada aquí… */
</style>
