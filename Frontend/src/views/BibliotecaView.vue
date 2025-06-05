<!-- src/views/BibliotecaView.vue -->
<template>






  <RecentlyPlayed />
  <AllGameGrid />



</template>

<script setup>
import { computed } from 'vue'
import { useLoginStore } from '../stores/useLoginStore.js'





import RecentlyPlayed from '../components/Biblioteca/RecentlyPlayed.vue'
import AllGameGrid from '../components/Biblioteca/AllGamesGrid.vue'

// 1) Instanciamos la store de login
const loginStore = useLoginStore()

// 2) Computed que lee el rol
//    Si loginStore.user es null, entonces loginStore.rol será null y entra en la rama “invitado”
const rol = computed(() => loginStore.rol)
</script>

<style scoped>
/* Margen vertical para separar del navbar */
.biblioteca-view {
  margin-top: 2rem;
  margin-bottom: 2rem;
}

/* Asegura que el contenido encaje bien en pantallas muy pequeñas */
@media (max-width: 575px) {
  .biblioteca-view {
    margin-top: 1rem;
    margin-bottom: 1rem;
  }
}
</style>
