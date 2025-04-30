<!-- src/components/Home/BestGameCards.vue -->
<template>
    <div class="container mt-3">
        <section class="best-games-cards mt-3">
            <h2 id="mejoresJuegos">Mejores Juegos</h2>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
                <div class="col" v-for="game in games" :key="game.id">
                    <BestGameCard :link="game.link" :img="game.img" 
                        :characterImg="game.characterImg" :aos="game.aos" :duration="game.duration"
                        :delay="game.delay" />
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import BestGameCard from '../Home/BestGameCard/BestGameCard.vue'

const props = defineProps({
    games: {
        type: Array,
        default: () => []
    }
})
</script>

<style scoped>
#mejoresJuegos {
    position: relative;
    margin-bottom: 100px;
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