import { createApp } from 'vue'
import App from './App.vue'
import router from './router'       // ← aquí importas tu router

import './assets/global.css'        // tu CSS global

const app = createApp(App)

app.use(router)                     // ← aquí registras Vue Router
app.mount('#app')                   // montas tu App en el div#app
