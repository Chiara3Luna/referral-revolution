// assets/js/app.js
import { createApp } from 'vue'
import App from './components/App.vue'
import store from "../src/Store/store.js"
import router from "../src/Router/router.js"

createApp(App).use(router).use(store).mount('#app')

