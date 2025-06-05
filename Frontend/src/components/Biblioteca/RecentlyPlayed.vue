<template>
  <section class="recently-played-section container mt-3">
    <!-- Título de la sección -->
    <h2 class="recently-played-title">Jugados Recientemente</h2>
    <!-- Fila de cards -->
    <div class="row">
      <div
        v-for="(game, index) in games"
        :key="index"
        class="col-md-3 mb-4"
      >
        <!-- Componente de la card -->
        <RecentlyPlayedCard
          :image="game.image"
          :title="game.title"
          :delay="game.delay"
        />
      </div>
    </div>
  </section>
</template>

<script>
import RecentlyPlayedCard from '../Biblioteca/RecentlyPlayCard/RecentlyPlayCard.vue';

export default {
  name: 'RecentlyPlayed',
  components: { RecentlyPlayedCard },
  props: {
    games: {
      type: Array,
      required: true
    }
  }
};
</script>


<style scoped>
/* Contenedor principal de la sección */
.recently-played-section {
  /* Asegura márgenes verticales adecuados */
  margin-top: 2rem;
  margin-bottom: 2rem;
  max-width: 100%;
}

/* Estilo para el título de “Jugados Recientemente” */
.recently-played-title {
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
.recently-played-title::after {
  content: "";
  position: absolute;
  width: 10%;
  height: 3px;
  background-color: #39ff14;
  bottom: -8px;
  left: 0;
}

/* Ajuste de espacios entre las columnas en pantallas pequeñas */
@media (max-width: 767px) {
  .recently-played-section .col-md-3 {
    margin-bottom: 1rem;
  }
}
</style>
