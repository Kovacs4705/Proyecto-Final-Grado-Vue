<template>
  <section class="games-grid-section">
    <div class="row">
      <!-- Filtro lateral -->
      <div class="col-lg-3 mb-4">
        <aside class="filter-sidebar p-4">
          <h2 class="filter-title mb-4">Filtrar Juegos</h2>
          <div class="search-bar input-group mb-4">
            <input type="text" class="form-control search-input" placeholder="Buscar por título…"
              v-model="searchTerm" />
            <button class="btn search-btn" type="button">
              <i class="fas fa-search"></i>
            </button>
          </div>
          <div class="mb-3" v-for="filter in filters" :key="filter.label">
            <label class="form-label">{{ filter.label }}</label>
            <select class="form-select filter-select" v-for="(filter, idx) in filters" :key="filter.label"
              v-model="selectedFilters[idx]">
              <option v-for="option in filter.options" :key="option">{{ option }}</option>
            </select>
          </div>
          <button class="btn btn-success w-100 apply-btn">APLICAR FILTROS</button>
        </aside>
      </div>

      <!-- Cards de juegos -->
      <div class="col-lg-9">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
          <div class="col" v-for="(game, index) in filteredGames" :key="index" :data-aos="game.aos"
            :data-aos-duration="game.duration">
            <ExploreGameCard :img="game.img" :title="game.title" :price="game.price" />
          </div>
          <div v-if="games.length === 0" class="text-center text-muted py-5">
            No hay juegos para mostrar.
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { defineProps } from 'vue'
import ExploreGameCard from '../Explorar/ExploreGameCard/ExploreGameCard.vue'

const props = defineProps({
  games: {
    type: Array,
    required: true
  },
  filters: {
    type: Array,
    required: true
  }
})

// Estado para los filtros seleccionados
const selectedFilters = ref(props.filters.map(() => 'Todos'))
const searchTerm = ref('')

// Computed para filtrar los juegos
const filteredGames = computed(() => {
  return props.games.filter(game => {
    // Filtro por título
    const matchesTitle = game.title.toLowerCase().includes(searchTerm.value.toLowerCase())

    // Filtro por género (si existe en el objeto game)
    const genreFilterIdx = props.filters.findIndex(f => f.label === 'Género')
    const selectedGenre = selectedFilters.value[genreFilterIdx]
    const matchesGenre = selectedGenre === 'Todos' || (game.genre === selectedGenre)

    // Filtro por plataforma (si existe en el objeto game)
    const platformFilterIdx = props.filters.findIndex(f => f.label === 'Plataforma')
    const selectedPlatform = selectedFilters.value[platformFilterIdx]
    const matchesPlatform = selectedPlatform === 'Todos' || (game.platform === selectedPlatform)

    // Puedes agregar más filtros aquí según tus datos

    return matchesTitle && matchesGenre && matchesPlatform
  })
})

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
