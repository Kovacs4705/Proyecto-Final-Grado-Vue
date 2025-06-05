<!-- src/views/NoticiasView.vue -->
<template>
  <!-- NAVBAR SEGÚN ROL -->
  <div v-if="rol === 'admin'">
    <NavbarAdmin />
  </div>
  <div v-else-if="rol === 'usuario'">
    <NavbarUsuario />
  </div>
  <div v-else>
    <NavbarInvitado />
  </div>

  <!-- CONTENIDO DE NOTICIAS SEGÚN ROL -->
  <div class="noticias-view container mt-4" v-if="rol === 'admin'">
    <p>admin</p>
    <!-- Sección Noticias de Hoy -->
    <section class="section-todays-news">
      <TodaysNewsAdmin />
    </section>

      

  </div>

  <div class="noticias-view container mt-4" v-else-if="rol === 'usuario'">
    <p>usuario</p>
    <!-- Sección Noticias de Hoy -->
    <section class="section-todays-news">
      <TodaysNewsUsuario />
    </section>

    <!-- Sección Noticias Generales -->
   
  </div>

  <div class="noticias-view container mt-4" v-else>
    <p>Invitado</p>
    <!-- Sección Noticias de Hoy -->
    <section class="section-todays-news">
      <TodaysNewsInvitado />
    </section>

    <!-- Separador -->
    <hr class="mt-5 mb-5 separator" />

    
  </div>

  <FooterGeneral />
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import AOS from 'aos'
import 'aos/dist/aos.css'

import { useLoginStore } from '../stores/useLoginStore.js'

// Importar los componentes de navegación
import NavbarAdmin    from '../components/Admin/Navbar.vue'
import NavbarUsuario  from '../components/Usuario/Navbar.vue'
import NavbarInvitado from '../components/Invitado/Navbar.vue'
import FooterGeneral  from '../components/Footer.vue'

// Importar componentes de “Noticias” para cada rol
import TodaysNewsAdmin    from '../components/Admin/Noticias/TodaysNews.vue'
import TodaysNewsUsuario  from '../components/Usuario/Noticias/TodaysNews.vue'
import TodaysNewsInvitado from '../components/Invitado/Noticias/TodaysNews.vue'

import GeneralNewsCardAdmin    from '../components/Admin/Noticias/GeneralNews.vue'
import GeneralNewsCardUsuario   from '../components/Usuario/Noticias/GeneralNews.vue'
import GeneralNewsCardInvitado  from '../components/Invitado/Noticias/GeneralNews.vue'

// 1) Crea la store de login
const loginStore = useLoginStore()

// 2) Computed para obtener el rol actual
const rol = computed(() => loginStore.rol)

// Lista de noticias generales (idéntica para todos los roles en este ejemplo)
const generalNewsList = ref([
  {
    image: "/images/fornitenoticia.png",
    title: "Noticia General 1",
    description:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, corrupti illo distinctio minus.",
  },
  {
    image: "/images/rocket.png",
    title: "Noticia General 2",
    description:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, corrupti illo distinctio minus.",
  },
  {
    image: "/images/fornitenoticia.png",
    title: "Noticia General 3",
    description:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, corrupti illo distinctio minus.",
  },
  {
    image: "/images/rocket.png",
    title: "Noticia General 4",
    description:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, corrupti illo distinctio minus.",
  },
  {
    image: "/images/fornitenoticia.png",
    title: "Noticia General 5",
    description:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, corrupti illo distinctio minus.",
  },
  {
    image: "/images/rocket.png",
    title: "Noticia General 6",
    description:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, corrupti illo distinctio minus.",
  },
])

// Inicializar AOS al montar el componente
onMounted(() => {
  AOS.init()
})
</script>

<style scoped>
.noticias-view {
  max-width: 1200px;
  margin: 0 auto;
  padding-bottom: 4rem;
}

/* Separador */
.separator {
  border: none;
  height: 1px;
  background-color: rgba(255, 255, 255, 0.2);
}

/* Título sección Noticias Generales */
.general-title {
  font-family: "Oswald", sans-serif;
  font-size: 2rem;
  color: #ffffff;
  position: relative;
}
.general-title::after {
  content: "";
  position: absolute;
  bottom: -8px;
  left: 50%;
  transform: translateX(-50%);
  width: 6%;
  height: 3px;
  background-color: #39ff14;
}

/* Ajustes de responsive para cards */
.section-general-news .col-md-4 {
  margin-bottom: 2rem;
}

/* Margen superior para Noticias de Hoy */
.section-todays-news {
  margin-top: 2rem;
}

/* Colocar espacio debajo de cada tarjeta */
.general-news-card {
  background-color: transparent;
}
</style>
