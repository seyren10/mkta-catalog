import { createRouter, createWebHistory } from "vue-router";
import { useUserStore } from "@/stores/userStore";

import CatalogLayout from "@/Layouts/CatalogLayout.vue";
import MainLayout from "@/Layouts/MainLayout.vue";
import Login from "@/Pages/Auth/Login.vue";

import ActionNotAllowed from "@/components/ActionNotAllowed.vue";
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
        path: "/catalog",
        name: "catalog",
        component: CatalogLayout,
        meta: {
            requiresAuth: true,
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
    routes,
});

router.beforeEach(async (to, from) => {
    if (to.meta.requiresAuth) {
        const userStore = useUserStore();
        await userStore.getUser();

        const { user } = userStore;

        if (!user) {
            return { name: "fallback", query: { type: "unAuthorized" } };
        }
    }
});

export default router;
