<!-- src/App.vue -->
<template>
  <main>
    <router-view />
  </main>


</template>

<script setup>
import { ref } from 'vue'
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
