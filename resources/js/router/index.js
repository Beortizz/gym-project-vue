import { createRouter, createWebHistory } from "vue-router";

import studentIndex from "../components/students/students.vue";
import exercisesIndex from "../components/exercises/exercises.vue";

const routes = [
    {
        path: "/students",
        name: "studentIndex",
        component: studentIndex,
    },
    {
        path: "/exercises",
        name: "exercisesIndex",
        component: exercisesIndex,
    },
    {
        path: "/",
        redirect: "/students",
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;