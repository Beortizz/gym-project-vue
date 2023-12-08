import { createRouter, createWebHistory } from "vue-router";

import studentIndex from "../components/students/students.vue";

const routes = [
    {
        path: "/students",
        name: "studentIndex",
        component: studentIndex,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;