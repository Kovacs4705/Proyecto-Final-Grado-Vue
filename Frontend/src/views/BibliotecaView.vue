<template>
  <div class="biblioteca-view">
    <RecentlyPlayed :games="games" />
    <AllGameGrid :games="games" />
  </div>
</template>

<script setup>
import { onMounted, computed } from 'vue'
import { useGamesStore } from '../stores/useGamesStore.js'
import { useLoginStore } from '../stores/useLoginStore.js'
import RecentlyPlayed from '../components/Biblioteca/RecentlyPlayed.vue'
import AllGameGrid from '../components/Biblioteca/AllGamesGrid.vue'

// Instancia de stores
const gamesStore = useGamesStore()
const loginStore = useLoginStore()

// Computed para el rol (si lo necesitas)
const rol = computed(() => loginStore.rol)

// Cargar juegos al montar la vista
onMounted(() => {
  gamesStore.fetchGames()
})

// Computed para los juegos en formato esperado por los componentes hijos
const games = computed(() =>
  gamesStore.games.map((j, idx) => ({
    image: j.juego_imagens && j.juego_imagens.length
      ? `data:image/jpeg;base64,${j.juego_imagens[0].imagen}`
      : '/images/default.png',
    title: j.nombre,
    delay: 100 * idx // Puedes ajustar el delay como prefieras
  }))
)
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
