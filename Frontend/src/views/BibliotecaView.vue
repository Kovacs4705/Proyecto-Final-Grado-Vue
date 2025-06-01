<!-- src/views/BibliotecaView.vue -->
<template>
  <div class="biblioteca-view">
    <!-- Sección “Jugados Recientemente” -->
    <RecentlyPlayed />

    <!-- Sección “Todos Tus Juegos” -->
    <AllGameGrid />
  </div>
</template>

<script setup>
// Importa los componentes que ya creaste
import RecentlyPlayed from '../components/Biblioteca/RecentlyPlayed.vue'
import AllGameGrid from '../components/Biblioteca/AllGamesGrid.vue'
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
