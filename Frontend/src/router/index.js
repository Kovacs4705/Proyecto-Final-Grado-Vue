// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router'

import LoginView      from '../views/LoginView.vue'
import HomeView       from '../views/HomeView.vue'
import ExplorarView   from '../views/ExplorarView.vue'
import BibliotecaView from '../views/BibliotecaView.vue'
import NoticiasView   from '../views/NoticiasView.vue'
import PanelControl   from '../views/PanelControlView.vue'

import { useLoginStore } from '../stores/useLoginStore.js'

const routes = [
  // 1) Raíz redirige a /login
  { path: '/', redirect: '/login' },

  // 2) Login (accesible para todos)
  {
    path: '/login',
    name: 'login',
    component: LoginView
  },

  // 3) Home (todos los roles pueden verlo)
  {
    path: '/home',
    name: 'home',
    component: HomeView
  },

  // 4) Explorar (todos los roles)
  {
    path: '/explorar',
    name: 'explorar',
    component: ExplorarView
  },

  // 5) Biblioteca → solo “administrador” o “usuario” (no invitado)
  {
    path: '/biblioteca',
    name: 'biblioteca',
    component: BibliotecaView,
    meta: { requiresAuth: true } // requiere rol ≠ null
  },

  // 6) Noticias (todos los roles)
  {
    path: '/noticias',
    name: 'noticias',
    component: NoticiasView
  },

  // 7) Panel de Control → solo “administrador”
  {
    path: '/panel',
    name: 'panel',
    component: PanelControl,
    meta: { requiresAdmin: true }
  },

  // 8) Cualquier otra → redirigir a /login
  { path: '/:catchAll(.*)', redirect: '/login' }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

// ========== GUARD GLOBAL ==========
// Comprueba cada cambio de ruta antes de entrar
router.beforeEach((to, from) => {
  const loginStore = useLoginStore()
  const rol = loginStore.rol  // puede ser 'administrador', 'usuario' o null (invitado)

  // 1) Si la ruta necesita “admin” y el rol no es 'administrador', mandar a /home
  if (to.meta.requiresAdmin && rol !== 'administrador') {
    return { name: 'home' }
  }


  if (to.meta.requiresAuth && rol === null) {
    return { name: 'home' }
  }

  // 3) Si el usuario ya está logueado y va a /login, redirigir a /home
  if (to.name === 'login' && rol !== null) {
    return { name: 'home' }
  }

  // 4) En cualquier otro caso, permitir navegación
  return true
})

export default router
