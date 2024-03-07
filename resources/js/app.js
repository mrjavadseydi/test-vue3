import { createApp } from 'vue';
import Index from './IndexComponent.vue';

createApp({})
    .component('IndexComponent', Index)
    .mount('#app')
