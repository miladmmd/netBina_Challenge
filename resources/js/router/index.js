import { createRouter, createWebHistory } from 'vue-router'
import Login from "../pages/Login.vue";
import Panel from "../pages/Panel.vue"


const routes = [
    {
        path:"/",
        name:"Login",
        component:Login
    },
    {
        path:"/panel",
        name:"Panel",
        component:Panel
    },

];

const router = createRouter({
    history:createWebHistory(),
    routes,
});

export default router;
