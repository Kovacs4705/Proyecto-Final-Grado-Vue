<!-- src/components/Home/BestGamesCards.vue -->
<template>
    <section class="best-games-cards mt-3">
        <h2 id="mejoresJuegos" class="text-center mt-3">Mejores Juegos</h2>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
            <div class="col" v-for="game in games" :key="game.id">
                <GameCard :img="game.img" :title="game.title" :price="game.price" />
            </div>
        </div>
    </section>
</template>

<script setup>
import GameCard from '../Home/BestGameCard/BestGameCard.vue'

const props = defineProps({
    games: {
        type: Array,
        default: () => []
    }
})
</script>

<style scoped>
/* Línea verde bajo el título Tal y como en tu style.css */
#mejoresJuegos {
    position: relative;
    margin-bottom: 1rem;
}

#mejoresJuegos::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 6%;
    height: 3px;
    background-color: #39ff14;
}

/* :contentReference[oaicite:0]{index=0}&#8203;:contentReference[oaicite:1]{index=1} */

/* Ajustes de espaciado */
.best-games-cards {
    padding: 0 1rem;
}

.best-games-cards .row>.col {
    display: flex;
}

/* Hacemos que GameCard llenen su columna */
.best-games-cards GameCard {
    flex: 1;
}
</style>