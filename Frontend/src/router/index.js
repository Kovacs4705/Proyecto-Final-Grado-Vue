// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router'

import LoginView from '../views/LoginView.vue'

// Admin
import HomeAdmin from '../views/HomeView.vue'
// import ExplorarAdmin from '../views/ExplorarView.vue'
// import BibliotecaAdmin from '../views/BibliotecaView.vue'
// import NoticiasAdmin from '../views/NoticiasView.vue'

// Usuario
import HomeUsuario from '../views/HomeView.vue'
// import ExplorarUsuario from '../views/ExplorarView.vue'
// import BibliotecaUsuario from '../views/BibliotecaView.vue'
// import NoticiasUsuario from '../views/NoticiasView.vue'

// Invitado
import HomeInvitado from '../views/HomeView.vue'
import ExplorarInvitado from '../views/ExplorarView.vue'
import NoticiasInvitado from '../views/NoticiasView.vue'

const routes = [
  { path: '/', name: 'root', redirect: '/login' },
  { path: '/login', name: 'login', component: LoginView },
  // Rutas Admin
  { path: '/admin', name: 'home-admin', component: HomeAdmin },
  // { path: '/admin/explorar', name: 'explorar-admin', component: ExplorarAdmin },
  // { path: '/admin/biblioteca', name: 'biblioteca-admin', component: BibliotecaAdmin },
  // { path: '/admin/noticias', name: 'noticias-admin', component: NoticiasAdmin },

  // Rutas Usuario
  { path: '/usuario', name: 'home-usuario', component: HomeUsuario },
  // { path: '/usuario/explorar', name: 'explorar-usuario', component: ExplorarUsuario },
  // { path: '/usuario/biblioteca', name: 'biblioteca-usuario', component: BibliotecaUsuario },
  // { path: '/usuario/noticias', name: 'noticias-usuario', component: NoticiasUsuario },

  // Rutas Invitado
  { path: '/invitado', name: 'home-invitado', component: HomeInvitado },
  { path: '/invitado/explorar', name: 'explorar-invitado', component: ExplorarInvitado },
  { path: '/invitado/noticias', name: 'noticias-invitado', component: NoticiasInvitado }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
