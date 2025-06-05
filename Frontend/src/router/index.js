// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router'

import LoginView      from '../views/LoginView.vue'
import HomeView       from '../views/HomeView.vue'
import ExplorarView   from '../views/ExplorarView.vue'
import BibliotecaView from '../views/BibliotecaView.vue'
import NoticiasView   from '../views/NoticiasView.vue'

// Componente “Panel de Control” que reutilizará sub-componentes existentes
import PanelControl   from '../views/PanelControlView.vue'

// Importamos Pinia para saber el rol del usuario
import { useLoginStore } from '../stores/useLoginStore.js'

const routes = [
  // 1) Raíz redirige a /login
  { path: '/', redirect: '/login' },

  // 2) Login (accesible para todos)
  { path: '/login', name: 'login', component: LoginView },

  // 3) Home (todos los roles pueden verlo)
  { path: '/home', name: 'home', component: HomeView },

  // 4) Explorar (todos los roles)
  { path: '/explorar', name: 'explorar', component: ExplorarView },

  // 5) Biblioteca → solo usuarios logueados (admin o usuario); invitado no.
  {
    path: '/biblioteca',
    name: 'biblioteca',
    component: BibliotecaView,
    meta: { requiresAuth: true }
  },

  // 6) Noticias (todos los roles)
  { path: '/noticias', name: 'noticias', component: NoticiasView },

  // 7) Panel de Control → solo admins
  {
    path: '/panel',
    name: 'panel',
    component: PanelControl,
    meta: { requiresAdmin: true }
  },

  // 8) Capturar todo lo demás → redirigir a /login
  { path: '/:catchAll(.*)', redirect: '/login' }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

// ========== GUARD GLOBAL ==========
// Aquí comprobamos cada vez que cambia de ruta si el usuario
// cumple con los requisitos de rol/autenticación.
router.beforeEach((to, from) => {
  const loginStore = useLoginStore()
  const rol = loginStore.rol  // Puede ser 'admin', 'usuario' o null (invitado)

  // 1) Si la ruta requiereAdmin y el rol no es 'admin', lo mandamos a /home
  if (to.meta.requiresAdmin && rol !== 'admin') {
    return { name: 'home' }
  }

  // 2) Si la ruta requiereAuth (biblioteca) y el rol es null, lo mandamos a /login
  if (to.meta.requiresAuth && rol === null) {
    return { name: 'login' }
  }

  // 3) Si el usuario ya está logueado (rol != null) y va a /login, lo mandamos a /home
  if (to.name === 'login' && rol !== null) {
    return { name: 'home' }
  }

  // 4) En cualquier otro caso, permitir la navegación
  return true
})

export default router
