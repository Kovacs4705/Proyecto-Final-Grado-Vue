<template>
  <aside class="filter-sidebar p-4">
    <h2 class="filter-title mb-4">Filtrar Juegos</h2>

    <!-- Barra de búsqueda -->
    <div class="search-bar input-group mb-4">
      <input
        v-model="searchQuery"
        type="text"
        class="form-control search-input"
        placeholder="Buscar por título…"
      />
      <button class="btn search-btn" type="button">
        <i class="fas fa-search"></i>
      </button>
    </div>

    <!-- Filtro Género -->
    <div class="mb-3">
      <label class="form-label">Género</label>
      <select v-model="selectedGenre" class="form-select filter-select">
        <option value="">Todos</option>
        <option v-for="genre in genres" :key="genre" :value="genre">
          {{ genre }}
        </option>
      </select>
    </div>

    <!-- Filtro Tipo -->
    <div class="mb-3">
      <label class="form-label">Tipo</label>
      <select v-model="selectedType" class="form-select filter-select">
        <option value="">Todos</option>
        <option v-for="type in types" :key="type" :value="type">
          {{ type }}
        </option>
      </select>
    </div>

    <!-- Filtro Plataforma -->
    <div class="mb-3">
      <label class="form-label">Plataforma</label>
      <select v-model="selectedPlatform" class="form-select filter-select">
        <option value="">Todos</option>
        <option v-for="platform in platforms" :key="platform" :value="platform">
          {{ platform }}
        </option>
      </select>
    </div>

    <!-- Filtro Instalado -->
    <div class="mb-4">
      <label class="form-label">Instalado</label>
      <select v-model="selectedInstalled" class="form-select filter-select">
        <option value="">Todos</option>
        <option value="yes">Sí</option>
        <option value="no">No</option>
      </select>
    </div>

    <button class="btn apply-btn w-100" @click="applyFilters">
      APLICAR FILTROS
    </button>
  </aside>
</template>

<script setup>
import { ref } from "vue";

const props = defineProps({
  genres: {
    type: Array,
    default: () => [],
  },
  types: {
    type: Array,
    default: () => [],
  },
  platforms: {
    type: Array,
    default: () => [],
  },
});

const emit = defineEmits(["filter"]);

const searchQuery = ref("");
const selectedGenre = ref("");
const selectedType = ref("");
const selectedPlatform = ref("");
const selectedInstalled = ref("");

const applyFilters = () => {
  emit("filter", {
    query: searchQuery.value,
    genre: selectedGenre.value,
    type: selectedType.value,
    platform: selectedPlatform.value,
    installed: selectedInstalled.value,
  });
};
</script>

<style scoped>
.filter-sidebar {
  background-color: #141414;
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
