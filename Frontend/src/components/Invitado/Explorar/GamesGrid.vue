<template>
  <section class="games-grid-section">
    <div class="row">
      <!-- Filtro lateral -->
      <div class="col-lg-3 mb-4">
        <aside class="filter-sidebar p-4">
          <h2 class="filter-title mb-4">Filtrar Juegos</h2>
          <div class="search-bar input-group mb-4">
            <input type="text" class="form-control search-input" placeholder="Buscar por título…" />
            <button class="btn search-btn" type="button">
              <i class="fas fa-search"></i>
            </button>
          </div>
          <div class="mb-3" v-for="filter in filters" :key="filter.label">
            <label class="form-label">{{ filter.label }}</label>
            <select class="form-select filter-select">
              <option>Todos</option>
            </select>
          </div>
          <button class="btn btn-success w-100 apply-btn">APLICAR FILTROS</button>
        </aside>
      </div>

      <!-- Cards de juegos -->
      <div class="col-lg-9">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
          <div
            class="col"
            v-for="(game, index) in games"
            :key="index"
            :data-aos="game.aos"
            :data-aos-duration="game.duration"
          >
            <ExploreGameCard
              :img="game.img"
              :title="game.title"
              :price="game.price"
            />
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import ExploreGameCard from '../Explorar/ExploreGameCard/ExploreGameCard.vue'

const filters = [
  { label: 'Género' },
  { label: 'Tipo' },
  { label: 'Plataforma' },
  { label: 'Instalado' },
]

const games = [
  {
    img: '/images/juego1.png',
    title: 'JEDI Falling Order',
    price: '60€',
    aos: 'fade-right',
    duration: 1000
  },
  {
    img: '/images/juego1.png',
    title: 'JEDI Falling Order',
    price: '60€',
    aos: 'fade-up',
    duration: 1000
  },
  {
    img: '/images/juego1.png',
    title: 'JEDI Falling Order',
    price: '60€',
    aos: 'fade-left',
    duration: 1000
  },
  {
    img: '/images/juego1.png',
    title: 'JEDI Falling Order',
    price: '60€',
    aos: 'fade-right',
    duration: 1000
  },
  {
    img: '/images/juego1.png',
    title: 'JEDI Falling Order',
    price: '60€',
    aos: 'fade-up',
    duration: 1000
  },
  {
    img: '/images/juego1.png',
    title: 'JEDI Falling Order',
    price: '60€',
    aos: 'fade-left',
    duration: 1000
  },
  {
    img: '/images/juego1.png',
    title: 'JEDI Falling Order',
    price: '60€',
    aos: 'fade-right',
    duration: 1000
  },
  {
    img: '/images/juego1.png',
    title: 'JEDI Falling Order',
    price: '60€',
    aos: 'fade-up',
    duration: 1000
  },
  {
    img: '/images/juego1.png',
    title: 'JEDI Falling Order',
    price: '60€',
    aos: 'fade-left',
    duration: 1000
  },
  {
    img: '/images/juego1.png',
    title: 'JEDI Falling Order',
    price: '60€',
    aos: 'fade-right',
    duration: 1000
  },
  {
    img: '/images/juego1.png',
    title: 'JEDI Falling Order',
    price: '60€',
    aos: 'fade-up',
    duration: 1000
  },
  {
    img: '/images/juego1.png',
    title: 'JEDI Falling Order',
    price: '60€',
    aos: 'fade-left',
    duration: 1000
  }
]
</script>

<style scoped>
.games-grid-section {
  max-width: 67%;
  margin: 100px auto;
}
.filter-sidebar {
  /* background-color: #141414; */
  border-radius: 10px;
  color: #fff;
  max-width: 300px;
}

.filter-title {
  font-size: 1.25rem;
  font-weight: bold;
  border-bottom: 3px solid #39ff14;
  padding-bottom: 0.25rem;
  display: inline-block;
}

.search-bar .search-input {
  background-color: #141414;
  border-right: none;
  color: #fff;
  border: none;
}

.search-bar .search-btn {
  background-color: #141414;
  border-left: none;
  color: #fff;
}

.search-bar .search-btn:hover {
  color: #39ff14;
}

.filter-select {
  background-color: black;
  border: 1px solid #39ff14;
  border-radius: 8px;
  color: #fff;
}

.apply-btn {
  background-color: #58de65;
  border: none;
  border-radius: 8px;
  font-weight: bold;
  padding: 0.5rem 0;
  color: black;
}

.apply-btn:hover {
  background-color: #2abb0f;
  color: #000;
}

.form-label {
  display: flex;
  margin-bottom: 0.25rem;
  font-weight: 500;
}
</style>
