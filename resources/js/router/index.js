import { createRouter, createWebHistory } from "vue-router";

import productIndex from '../components/products/Index.vue';
import notFound from '../components/notFound.vue';
import productForm from '../components/products/Form.vue';
import Login from "../components/auth/login.vue";

const routes = [
    {
        path:'/',
        name:'products.index',
        component: productIndex
        
    },
    {
        path:'/products/create',
        name:'products.create',
        component: productForm
    },
    {
        path:'/login',        
        component: Login
    },
    {
        path:'/:pathMatch(.*)*',
        name:'notfound',
        component: notFound
    }
]
const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router