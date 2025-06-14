<!-- src/views/ExploreView.vue -->
<template>
    <div>
        <FeaturedSection :featured-item="featuredData" />
        <GenresCarousel :genres="genresData" />
        <GamesGrid :games="gamesData" :filters="filters" />
    </div>
</template>

<script setup>
import { onMounted, computed } from "vue";
import { useGenerosStore } from "../stores/useGenerosStore.js";
import { useGamesStore } from "../stores/useGamesStore.js";

import FeaturedSection from "../components/Explorar/FeaturedSection.vue";
import GenresCarousel from "../components/Explorar/GenresCarousel.vue";
import GamesGrid from "../components/Explorar/GamesGrid.vue";

// Instancia los stores
const generosStore = useGenerosStore();
const gamesStore = useGamesStore();

// Carga los datos al montar la vista
onMounted(async() => {
    await generosStore.fetchGenres();
    await gamesStore.fetchGames();
    console.log("Géneros:", generosStore.genres);
    console.log("Juegos:", gamesStore.games);
});

// Datos estáticos para la sección destacada
// featuredData dinámico: imagen y título del primer juego, el resto estático
const featuredData = computed(() => {
    const firstGameRaw = gamesStore.games?.[0];
    const horizontalImg = firstGameRaw?.juego_imagens?.find(
        (img) => img.categoria === "horizontal"
    );
    return firstGameRaw
        ? {
              sectionTitle: "Destacado",
              imageUrl: horizontalImg
                  ? `data:image/jpeg;base64,${horizontalImg.imagen}`
                  : "/images/default.png",
              altText: `Imagen de ${firstGameRaw.nombre}`,
              headline: firstGameRaw.nombre,
              description:
                  "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, a aliquid corrupti illo distinctio minus, voluptates cum nobis ex enim deleniti reiciendis.",
              buttonText: "Comprar Ahora",
              buttonUrl: "#",
          }
        : {
              sectionTitle: "Destacado",
              imageUrl: "/images/NoticiaDestacada.png",
              altText: "Imagen Destacado",
              headline: "UNREAL TOURNAMENT",
              description:
                  "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, a aliquid corrupti illo distinctio minus, voluptates cum nobis ex enim deleniti reiciendis.",
              buttonText: "Comprar Ahora",
              buttonUrl: "#",
          };
});

// Adapta los géneros del store para el carrusel
const genresData = computed(() =>
    (generosStore.genres || []).map((g) => ({
        id: g.id_genero,
        title: g.nombre,
        imageUrl: g.imagen
            ? `data:image/jpeg;base64,${g.imagen}`
            : "/images/default.png",
    }))
);

// Adapta los juegos del store para el grid
const gamesData = computed(() =>
    (gamesStore.games || []).map((j) => {
        const verticalImg = j.juego_imagens?.find(
            (img) => img.categoria === "vertical"
        );
        return {
            id: j.id_juego,
            title: j.nombre,
            price: j.precio ? `${j.precio}€` : "",
            img: verticalImg
                ? `data:image/jpeg;base64,${verticalImg.imagen}`
                : "/images/default.png",
            genre: Array.isArray(j.generos)
                ? j.generos.map((g) => g.nombre)
                : [],
            platform: j.plataforma || "PC",
        };
    })
);

// Filtros como computed, depende de genresData
const filters = computed(() => [
    {
        label: "Género",
        options: ["Todos", ...genresData.value.map((g) => g.title)],
    },
    {
        label: "Plataforma",
        options: ["Todos", "PC", "Xbox", "PlayStation", "Switch", "Móvil"],
    },
]);
</script>

<style scoped>

</style>
