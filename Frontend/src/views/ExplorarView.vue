<!-- src/views/ExploreView.vue -->
<template>
  
    <FeaturedSection :featured-item="featuredData" />
    <GenresCarousel :genres="genresData" />
    <GamesGrid :games="gamesData" />
  
</template>

<script setup>
import { computed } from 'vue'
import { useLoginStore } from '../stores/useLoginStore.js'

// Importa componentes de navegación


// Importa componentes de sección “Explorar” para cada rol
import FeaturedSection   from '../components/Explorar/FeaturedSection.vue'
import GenresCarousel    from '../components/Explorar/GenresCarousel.vue'
import GamesGrid       from '../components/Explorar/GamesGrid.vue'



// 1) Instancia la store de login
const loginStore = useLoginStore()

// 2) Computed para el rol (puede ser 'admin', 'usuario' o null)
const rol = computed(() => loginStore.rol)

// Datos estáticos de ejemplo para "Destacado", "Géneros" y "Juegos"
const featuredData = {
  sectionTitle: "Destacado",
  imageUrl: "/images/NoticiaDestacada.png",
  altText: "Imagen Destacado",
  headline: "UNREAL TOURNAMENT",
  description:
    "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, a aliquid corrupti illo distinctio minus, voluptates cum nobis ex enim deleniti reiciendis.",
  buttonText: "Comprar Ahora",
  buttonUrl: "#"
}

const genresData = [
  { id: 1, title: "Aventuras",        imageUrl: "/images/fortnite1.png" },
  { id: 2, title: "Disparos",         imageUrl: "/images/spiderman1.png" },
  { id: 3, title: "Multiplataforma",  imageUrl: "/images/stranger1.png" },
  { id: 4, title: "Rol",              imageUrl: "/images/fortnite1.png" },
  { id: 5, title: "Estrategia",       imageUrl: "/images/spiderman1.png" }
]

const gamesData = [
  { id: 1, title: "JEDI Fallen Order", price: "60€", imageUrl: "/images/juego1.png" },
  { id: 2, title: "Cyberpunk 2077",    price: "50€", imageUrl: "/images/juego2.png" },
  { id: 3, title: "The Witcher 3",     price: "40€", imageUrl: "/images/juego3.png" },
  // ...otros juegos de ejemplo...
]
</script>

<style scoped>
/* Si necesitas estilos adicionales para esta vista, agrégalos aquí */
</style>
