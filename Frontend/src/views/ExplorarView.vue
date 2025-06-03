<!-- src/views/ExploreView.vue -->
<template>

  <div v-if="rol === 'admin'">
    <NavbarAdmin />
  </div>

  <div v-else-if="rol === 'usuario'">
    <NavbarUsuario />
  </div>

  <div v-else>
    <NavbarInvitado />
  </div>


  <div v-if="rol === 'admin'">
    <FeaturedSectionAdmin :featured-item="featuredData" />
    <GenresCarouselAdmin :genres="genresData" />
    <GamesGridAdmin :games="gamesData" />
  </div>

  <div v-if="rol === 'usuario'">
    <FeaturedSectionUsuario :featured-item="featuredData" />
    <GenresCarouselUsuario :genres="genresData" />
    <GamesGridUsuario :games="gamesData" />
  </div>

  <div v-else>
    <FeaturedSectionInvitado :featured-item="featuredData" />
    <GenresCarouselInvitado :genres="genresData" />
    <GamesGridInvitado :games="gamesData" />
  </div>



  <FooterGeneral />

</template>

<script>
import FooterGeneral from '../components/Footer.vue'
import NavbarAdmin from '../components/Admin/Navbar.vue'
import NavbarUsuario from '../components/Usuario/Navbar.vue'
import NavbarInvitado from '../components/Invitado/Navbar.vue'

import FeaturedSectionAdmin from "../components/Admin/Explorar/FeaturedSection.vue";
import GenresCarouselAdmin from "../components/Admin/Explorar/GenresCarousel.vue";
import GamesGridAdmin from "../components/Admin/Explorar/GamesGrid.vue";

import FeaturedSectionInvitado from "../components/Invitado/Explorar/FeaturedSection.vue";
import GenresCarouselInvitado from "../components/Invitado/Explorar/GenresCarousel.vue";
import GamesGridInvitado from "../components/Invitado/Explorar/GamesGrid.vue";

import FeaturedSectionUsuario from "../components/Usuario/Explorar/FeaturedSection.vue";
import GenresCarouselUsuario from "../components/Usuario/Explorar/GenresCarousel.vue";
import GamesGridUsuario from "../components/Usuario/Explorar/GamesGrid.vue";



export default {
  name: "ExploreView",
  components: {
    NavbarAdmin,
    NavbarUsuario,
    NavbarInvitado,

    FeaturedSectionAdmin,
    GenresCarouselAdmin,
    GamesGridAdmin,

    FeaturedSectionUsuario,
    GenresCarouselUsuario,
    GamesGridUsuario,

    FeaturedSectionInvitado,
    GenresCarouselInvitado,
    GamesGridInvitado,

    FooterGeneral
  },
  data() {
    return {
      featuredData: {
        sectionTitle: "Destacado",
        imageUrl: "/images/NoticiaDestacada.png",
        altText: "Imagen Destacado",
        headline: "UNREAL TOURNAMENT",
        description:
          "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, a aliquid corrupti illo distinctio minus, voluptates cum nobis ex enim deleniti reiciendis.",
        buttonText: "Comprar Ahora",
        buttonUrl: "#",
      },
      genresData: [
        { id: 1, title: "Aventuras", imageUrl: "/images/fortnite1.png" },
        { id: 2, title: "Disparos", imageUrl: "/images/spiderman1.png" },
        { id: 3, title: "Multiplataforma", imageUrl: "/images/stranger1.png" },
        { id: 4, title: "Rol", imageUrl: "/images/fortnite1.png" },
        { id: 5, title: "Estrategia", imageUrl: "/images/spiderman1.png" },
      ],
      // Ejemplo de datos para juegos; ajústalos según tu API
      gamesData: [
        {
          id: 1,
          title: "JEDI Fallen Order",
          price: "60€",
          imageUrl: "/images/juego1.png",
        },
        {
          id: 2,
          title: "Cyberpunk 2077",
          price: "50€",
          imageUrl: "/images/juego2.png",
        },
        {
          id: 3,
          title: "The Witcher 3",
          price: "40€",
          imageUrl: "/images/juego3.png",
        },
        // …más objetos de ejemplo…
      ],
    };
  },
};
</script>

<style scoped>
/* Si necesitas estilos adicionales para esta vista, agrégalos aquí */
</style>
