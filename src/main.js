import { createApp } from 'vue'
import App from './App.vue'
import router from './router'      // si lo usas

const app = createApp(App)
app.use(router)                   // solo si tienes rutas
app.mount('#app')
