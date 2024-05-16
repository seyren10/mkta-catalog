import { createRouter, createWebHistory } from "vue-router";
import { useUserStore } from "@/stores/userStore";

import CatalogLayout from "@/Layouts/CatalogLayout.vue";
import MainLayout from "@/Layouts/MainLayout.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";

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
        path: "/admin",
        name: "admin",
        component: AdminLayout,
        redirect: { name: "dashboard" },
        meta: {
            requiresAuth: true,
            // allowedRoles:
        },
        children: [
            {
                path: "dashboard",
                name: "dashboard",
                component: () => import("@/Pages/Admin/Dashboard/Index.vue"),
            },
            {
                path: "products",
                name: "products",
                component: () => import("@/Pages/Admin/Products/Index.vue"),
            },
        ],
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
    const userStore = useUserStore();
    await userStore.getUser();

    const { user } = userStore;
    if (to.meta.requiresAuth && !user) {
        return { name: "fallback", query: { type: "unAuthorized" } };
    }
});

export default router;
