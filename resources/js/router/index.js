import { createRouter, createWebHistory } from "vue-router";
import { useUserStore } from "@/stores/userStore";

import home_routes from "./router_home.js";
import admin_routes from "./router_admin.js";
import catalog_routes from "./router_catalog.js";

const routes = [
    {
        path: "/:pathMatch(.*)*",
        name: "notFound",
        component: () => import("@/components/ActionNotAllowed.vue"),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: [...routes, ...home_routes, ...catalog_routes, ...admin_routes],
    scrollBehavior(to, from, savedPosition) {
        if (to.hash) {
            return {
                el: to.hash,
                behavior: "smooth",
            };
        }

        if (savedPosition) {
            return savedPosition;
        } else {
            return { top: 0 };
        }
    },
});

router.beforeEach(async (to, from) => {
    const userStore = useUserStore();
    await userStore.getCurrentUser();

    if (to.meta.requiresAuth && !userStore.currentUser) {
        return {
            name: "notFound",
            params: {
                pathMatch: to.path.substring(1).split("/"),
            },
            // preserve existing query and hash if any
            query: to.query,
            hash: to.hash,
        };
    }
});

export default router;
