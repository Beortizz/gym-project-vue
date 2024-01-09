import { createRouter, createWebHistory } from "vue-router";


import axios from "../bootstrap.js";
import students from "../components/students/students.vue";
import exercises from "../components/exercises/exercises.vue";
import secretComponent from "../components/SecretComponent.vue";
import register from "../components/register.vue";

const routes = [
    {
        path: "/students",
        name: "studentIndex",
        component: students,
        meta : {
            requiresAuth : true
        }
    },
    {
        path: "/exercises",
        name: "exercisesIndex",
        component: exercises,
        meta : {
            requiresAuth : true
        }
    },
    {
        path: "/",
        redirect: "/login",
        meta : {
            requiresAuth : false
        }
    },
    {
        path: "/login",
        name: "login",
        component: secretComponent,
        meta : {
            requiresAuth : false
        }
    },
    {
        path: "/register",
        name: "register",
        component: register,
        meta : {
            requiresAuth : false
        }
    },

];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    // Verifique se a rota requer autenticação
    if (to.matched.some(record => record.meta.requiresAuth)) {
        // Verifique se há um token de autenticação no localStorage ou em qualquer lugar onde você armazene o token
        const token = localStorage.getItem('token'); // Supondo que você armazena o token no localStorage

        if (!token) {
            // Se não houver token, redirecione para a rota de login ou para onde desejar
            next({ name: 'login' });
        } else {
            // Adicione o token ao cabeçalho das requisições Axios para rotas autenticadas
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
            next();
        }
    } else {
        next(); // Continue para outras rotas públicas sem necessidade de autenticação
    }
});

export default router;