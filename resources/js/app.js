import { createApp } from 'vue';
import router from './components/router.js';
import app from './components/app.vue';
createApp(app).use(router).mount("#app");


// createApp({})
//     .component('IndexComponent', Index)
//     .mount('#app')
