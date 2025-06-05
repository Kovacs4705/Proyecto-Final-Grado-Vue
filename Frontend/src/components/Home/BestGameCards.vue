<!-- src/components/Home/BestGameCards.vue -->
<template>
    <div class="container mt-3">
        <section class="best-games-cards mt-3">
            <h2 id="mejoresJuegos">Mejores Juegos</h2>
            <div class="row">
                <div class="col" v-for="game in visibleGames" :key="game.id">
                    <BestGameCard :link="game.link" :img="game.img" :characterImg="game.characterImg" :aos="game.aos"
                        :duration="game.duration" :delay="game.delay" :title="game.title" :price="game.price" />
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
const ww = ref(innerWidth)
console.log('ww', ww.value);

function onResize() { ww.value = innerWidth }

onMounted(() => window.addEventListener('resize', onResize))
onBeforeUnmount(() => window.removeEventListener('resize', onResize))

// calculamos cuántas mostrar
const visibleGames = computed(() => {
    let cardsPerRow = 1; // móvil por defecto

    if (ww.value >= 576) cardsPerRow = 2;
    if (ww.value >= 768) cardsPerRow = 3;
    if (ww.value >= 992) cardsPerRow = 3;
    if (ww.value >= 1200) cardsPerRow = 3;
    if (ww.value >= 2560) cardsPerRow = 6 ;
    if (ww.value >= 3840) cardsPerRow = 9;  
    console.log('cardsPerRow', cardsPerRow);
    

    const maxCards = cardsPerRow * 2; 
    console.log('maxCards', maxCards);
    
    console.log(props.games.slice(0, maxCards));
    
    return props.games.slice(0, maxCards);
});
    
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