<!-- src/views/BibliotecaView.vue -->
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

  <!-- CONTENIDO DE BIBLIOTECA SEGÚN ROL -->
  <div v-if="rol === 'admin'" class="biblioteca-view">
    <RecentlyPlayedAdmin />
    <AllGameGridAdmin />
  </div>

  <div v-else-if="rol === 'usuario'" class="biblioteca-view">
    <RecentlyPlayedUsuario />
    <AllGameGridUsuario />
  </div>

  <FooterGeneral />
</template>

<script setup>
import { computed } from 'vue'
import { useLoginStore } from '../stores/useLoginStore.js'

// Importa los componentes correspondientes a cada rol
import NavbarAdmin    from '../components/Admin/Navbar.vue'
import NavbarUsuario  from '../components/Usuario/Navbar.vue'
import FooterGeneral  from '../components/Footer.vue'

import RecentlyPlayedAdmin   from '../components/Admin/Biblioteca/RecentlyPlayed.vue'
import AllGameGridAdmin      from '../components/Admin/Biblioteca/AllGamesGrid.vue'

import RecentlyPlayedUsuario from '../components/Usuario/Biblioteca/RecentlyPlayed.vue'
import AllGameGridUsuario    from '../components/Usuario/Biblioteca/AllGamesGrid.vue'

// 1) Instanciamos la store de login
const loginStore = useLoginStore()

// 2) Computed que lee el rol
//    Si loginStore.user es null, entonces loginStore.rol será null y entra en la rama “invitado”
const rol = computed(() => loginStore.rol)
</script>

<style scoped>
/* Margen vertical para separar del navbar */
.biblioteca-view {
  margin-top: 2rem;
  margin-bottom: 2rem;
}

/* Asegura que el contenido encaje bien en pantallas muy pequeñas */
@media (max-width: 575px) {
  .biblioteca-view {
    margin-top: 1rem;
    margin-bottom: 1rem;
  }
}
</style>
