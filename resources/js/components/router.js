import {createRouter, createWebHistory } from "vue-router";
import notFound from './notFound.vue'
import IndexComponent from "./IndexComponent.vue";
import UsersIndexComponent from "../../../Modules/Users/resources/assets/js/UsersIndexComponent.vue";
import Settings from "../../../Modules/Settings/resources/assets/js/Settings.vue";
import UsersComponent from "../../../Modules/Users/resources/assets/js/UsersComponent.vue";
const routes = [

    {

        path:   '/',

        component: IndexComponent
    },
    {

        path:   '/users',

        component: UsersComponent
    },  {

        path:   '/settings',

        component: Settings
    },
    {
        path: '/:pathMatch(.*)*',

        component: notFound
    },

]
const router = createRouter({

    history: createWebHistory(),

    routes

})

export default router
