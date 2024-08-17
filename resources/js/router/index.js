import { createRouter, createWebHistory } from "vue-router";
import { useUserStore } from "@/stores/userStore";

import home_routes from "./router_home.js";
import admin_routes from "./router_admin.js";
import catalog_routes from "./router_catalog.js";
import { storeToRefs } from "pinia";

const routes = [
    {
        path: "/login",
        name: "login",
        component: () => import("@/Pages/Auth/Login.vue"),
    },
    {
        path: "/:pathMatch(.*)*",
        name: "notFound",
        component: () => import("@/components/ActionNotAllowed.vue"),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: [...home_routes, ...catalog_routes, ...admin_routes, ...routes],

    // scrollBehavior(to, from, savedPosition) {
    //     if (to.hash) {
    //         return {
    //             el: to.hash,
    //             behavior: "smooth",
    //         };
    //     }

    //     if (savedPosition) {
    //         return savedPosition;
    //     } else {
    //         return { top: 0 };
    //     }
    // },
});

router.beforeEach(async (to, from) => {
    const userStore = useUserStore();
    const { currentUser } = storeToRefs(userStore);

    // if (to.hash) {
    //     return;
    // }

    if (to.meta.fullUserData) {
        await userStore.getCurrentUserFullData();
    } else await userStore.getCurrentUser();

    if (to.meta.requiresAuth && !currentUser.value) {
        return {
            name: "login",
        };
    }
});

export default router;
