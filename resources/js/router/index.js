import { createRouter, createWebHistory } from "vue-router";

import MainLayout from "@/Layouts/MainLayout.vue";

const routes = [
    {
        path: "/",
        name: "index",
        component: MainLayout,
        redirect: { name: "home" },
        children: [
            {
                path: "home",
                name: "home",
                component: () => import("@/Pages/Home/Index.vue"),
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
