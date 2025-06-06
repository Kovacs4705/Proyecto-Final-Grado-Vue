<template>
  <div class="biblioteca-view">
    <RecentlyPlayed :games="recentlyPlayed" />
    <AllGameGrid :games="allGames" />
  </div>
</template>

<script setup>
import { onMounted, computed } from 'vue'
import { useBibliotecasStore } from '../stores/useBibliotecasStore.js'
import { useLoginStore } from '../stores/useLoginStore.js'
import RecentlyPlayed from '../components/Biblioteca/RecentlyPlayed.vue'
import AllGameGrid from '../components/Biblioteca/AllGamesGrid.vue'

// Instancia de stores
const bibliotecaStore = useBibliotecasStore()
const loginStore = useLoginStore()

// Cargar biblioteca del usuario logueado al montar la vista
onMounted(async () => {
  await bibliotecaStore.fetchBibliotecaUsuarioLogueado()
  console.log(games.value) // Verifica que los juegos se carguen correctamente
  console.log(loginStore.usuario) // Verifica que el usuario esté logueado;
  
})

// Computed para los juegos en formato esperado por los componentes hijos
const games = computed(() =>
  (bibliotecaStore.biblioteca || []).map((j, idx) => {
    // Buscar imagen de categoría 'vertical'
    const verticalImg = j.juego_imagens?.find(img =>
      img.categoria === 'vertical' 
    )
    return {
      image: verticalImg
        ? `data:image/jpeg;base64,${verticalImg.imagen}`
        : '/images/default.png',
      title: j.nombre,
      delay: 200 * idx // Puedes ajustar el delay como prefieras
    }
  })
)

// Los primeros 4 juegos para RecentlyPlayed
const recentlyPlayed = computed(() => games.value.slice(0, 4))

// Los primeros 10 juegos para AllGameGrid
const allGames = computed(() => games.value.slice(0, 10))
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