<!-- src/components/Home/BestGameCards.vue -->
<template>
    <div class="container mt-5">
        <section class="best-games-cards mt-3">
            <h2 id="mejoresJuegos" class="text-center">Mejores Juegos</h2>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
                <div class="col" v-for="game in games" :key="game.id">
                    <BestGameCard :img="game.img" :title="game.title" :price="game.price" :aos="game.aos"
                        :duration="game.duration" :delay="game.delay" />
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
    display: flex;
    text-align: left;
    /* Alinea el título a la izquierda */
    margin-bottom: 100px;
    position: relative;
    /* Necesario para posicionar la línea */
}

#mejoresJuegos::after {
    content: '';
    position: absolute;
    width: 6%;
    /* 1/3 del ancho del título */
    height: 3px;
    /* Ajusta el grosor de la línea */
    background-color: #39ff14;
    /* Verde fosforescente */
    bottom: -10px;
    /* Ajusta la distancia de la línea al título */
    left: 0;
    /* Inicia la línea desde la izquierda del título */
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