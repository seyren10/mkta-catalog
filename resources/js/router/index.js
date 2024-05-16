import { createRouter, createWebHistory } from "vue-router";
import { useUserStore } from "@/stores/userStore";

import MainLayout from "@/Layouts/MainLayout.vue";
import ActionNotAllowed from "@/components/ActionNotAllowed.vue";

import home_routes from "./router_home.js"
import admin_routes from "./router_admin.js"
import catalog_routes from "./router_catalog.js"


const routes = [
    {
        path: "/",
        name: "index",
        component: MainLayout,
        beforeEnter(to, from, next) {
            if (to.hash) {
                next(); // No need to redirect
            } else {
                // Redirect to the same route with the hash fragment added
                next({ path: "/", hash: "#home" });
            }
        },
    },
    {
        path: "/fallback",
        name: "fallback",
        component: ActionNotAllowed,
        beforeEnter(to, from, next) {
            if (to.query.type) {
                next(); // No need to redirect
            } else {
                // Redirect to the same route with the hash fragment added
                next({ name: "fallback", query: { type: "notFound" } });
            }
        },
    },
    {
        path: "/:catchAll(.*)",
        name: "notFound",
        redirect: { name: "fallback" },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes : [
        ...routes,
        ...home_routes,
        ...catalog_routes,
        ...admin_routes,
    ],
});

router.beforeEach(async (to, from) => {
    const userStore = useUserStore();
    await userStore.getUser();

    const { user } = userStore;
    if (to.meta.requiresAuth && !user) {
        return { name: "fallback", query: { type: "unAuthorized" } };
    }
});

export default router;
