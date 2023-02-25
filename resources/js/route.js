import * as VueRoute from 'vue-router';
import test2 from "./components/test2.vue";
import test3 from "./components/test3.vue";
import test4 from "./components/test4.vue";

const routes = [
    {
        path: '/',
        name: 'test2',
        component: test2
    },

    {
        path: '/',
        name: 'test3',
        component: test3
    },

    {
        path: '/',
        name: 'test4',
        component: test4
    },


];

const router = VueRoute.createRouter({
    history: VueRoute.createWebHistory("/"),
    routes
})
export default router
