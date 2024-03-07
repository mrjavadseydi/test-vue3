import { createApp } from 'vue';
import UsersComponent from './UsersComponent.vue';
console.log(
    'app.js is running'
);
createApp({})
    .component('UsersComponent', UsersComponent)
    .mount('#users')
