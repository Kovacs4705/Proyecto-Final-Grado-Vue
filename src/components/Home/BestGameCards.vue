<!-- src/components/Home/BestGameCards.vue -->
<template>
    <div class="container mt-3">
        <section class="best-games-cards mt-3">
            <h2 id="mejoresJuegos">Mejores Juegos</h2>
            <div class="row g-5">
                <div class="col" v-for="game in visibleGames" :key="game.id">
                    <BestGameCard :link="game.link" :img="game.img" :characterImg="game.characterImg" :aos="game.aos"
                        :duration="game.duration" :delay="game.delay" :title="game.title" :price="game.price"/>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, computed } from 'vue'
import BestGameCard from '../Home/BestGameCard/BestGameCard.vue'

const props = defineProps({
    games: { type: Array, default: () => [] }
})

// reactivo al ancho de ventana
const ww = ref(window.innerWidth)
function onResize() { ww.value = window.innerWidth }

onMounted(() => window.addEventListener('resize', onResize))
onBeforeUnmount(() => window.removeEventListener('resize', onResize))

// calculamos cuántas mostrar
const visibleGames = computed(() => {
    let limit = 2        // móvil
    if (ww.value >= 576) limit = 4   // pantallas ≥ sm
    if (ww.value >= 768) limit = 6   // ≥ md
    if (ww.value >= 992) limit = 8   // ≥ lg
    if (ww.value >= 1200) limit = 14  // ≥ xl
    return props.games.slice(0, limit)
})
</script>

<style scoped>
#mejoresJuegos {
    position: relative;
    margin-bottom: 50px;
    text-align: left;
}

#mejoresJuegos::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 6%;
    height: 3px;
    background-color: #39ff14;
}

.best-games-cards {
    padding: 0 1rem;
}

.best-games-cards .row>.col {
    display: flex;
}

.best-games-cards BestGameCard {
    flex: 1;
}
</style>