<!-- src/components/AllGameGrid.vue -->
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

<script>
import LibraryGameCard from '../Biblioteca/LibraryGameCard/LibraryGameCard.vue';

export default {
  name: 'AllGameGrid',
  components: { LibraryGameCard },
  data() {
    return {
      games: [
        {
          image: '/images/hordes.png',
          title: 'Nier Automata',
          delay: 200
        },
        {
          image: '/images/citizen.png',
          title: 'Cyberpunk 2077',
          delay: 400
        },
        {
          image: '/images/Crysis.png',
          title: 'Crysis Remastered',
          delay: 600
        },
        {
          image: '/images/fantasy.png',
          title: 'Final Fantasy XV',
          delay: 800
        },
        {
          image: '/images/farming.png',
          title: 'Farming Simulator 22',
          delay: 1000
        },
        {
          image: '/images/heart.png',
          title: 'Hearthstone',
          delay: 200
        },
        {
          image: '/images/Outlast.png',
          title: 'Outlast II',
          delay: 400
        },
        {
          image: '/images/Mortal.png',
          title: 'Mortal Kombat 11',
          delay: 600
        },
        {
          image: '/images/tankhead.png',
          title: 'World of Tanks',
          delay: 800
        },
        {
          image: '/images/Crysis.png',
          title: 'JEDI Falling Order',
          delay: 1000
        },
        {
          image: '/images/citizen.png',
          title: 'Uncharted 4',
          delay: 200
        },
        {
          image: 'images/fantasy.png',
          title: 'Final Fantasy VII',
          delay: 400
        },
        {
          image: '/images/farming.png',
          title: 'Nier Automata',
          delay: 600
        },
        {
          image: 'images/fantasy.png',
          title: 'Final Fantasy VII',
          delay: 800
        },
        {
          image: 'images/fantasy.png',
          title: 'Final Fantasy VII',
          delay: 1000
        }
      ]
    };
  }
};
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
