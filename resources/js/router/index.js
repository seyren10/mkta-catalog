import { createRouter, createWebHistory } from "vue-router";

import MainLayout from "@/Layouts/MainLayout.vue";

const routes = [
    {
        path: "/",
        name: "index",
        component: MainLayout,
        beforeEnter(to, from, next) {
            if (to.hash === "#home") {
                next(); // No need to redirect
            } else {
                // Redirect to the same route with the hash fragment added
                next({ path: "/", hash: "#home" });
            }
        },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
