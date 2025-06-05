<template>
  <section class="all-games-section container mt-3">
    <!-- Título de la sección -->
    <h2 class="all-games-title">Todos Tus Juegos</h2>

    <!-- Grid de tarjetas -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
      <div
        v-for="(game, index) in games"
        :key="index"
        class="col"
      >
        <LibraryGameCard
          :image="game.image"
          :title="game.title"
          :delay="game.delay"
        />
      </div>
    </div>
  </section>
</template>

<script setup>
import LibraryGameCard from '../Biblioteca/LibraryGameCard/LibraryGameCard.vue'

defineProps({
  games: {
    type: Array,
    required: true
  }
})
</script>

<style scoped>
/*--------------------------------------------------------------------------------*/
/*------------------------ AllGameGrid: Estilos específicos ---------------------*/
/*--------------------------------------------------------------------------------*/

/* Contenedor principal de la sección */
.all-games-section {
  margin-top: 2rem;
  margin-bottom: 2rem;
  max-width: 100%;
}

/* Título “Todos Tus Juegos” */
.all-games-title {
  display: flex;
  text-align: left;
  margin-bottom: 1.5rem;
  position: relative;
  font-size: 2rem;
  color: white;
  font-family: 'Roboto', sans-serif;
  font-weight: bold;
}

/* Línea fosforescente debajo del título */
.all-games-title::after {
  content: "";
  position: absolute;
  width: 8%;
  height: 3px;
  background-color: #39ff14;
  bottom: -8px;
  left: 0;
}

/* Ajuste de gap entre las cards (Bootstrap “g-4” ya añade espaciado) */
.row {
  margin-left: 0;
  margin-right: 0;
}

/* Punto de ruptura para pantallas pequeñas, ajusta columnas */
@media (max-width: 575px) {
  .all-games-section .col {
    margin-bottom: 1rem;
  }
}
</style>
