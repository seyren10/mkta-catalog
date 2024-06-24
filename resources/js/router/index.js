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
        redirect: { name: "catalogHome" },
        meta: {
            requiresAuth: true,
        },
        children: [
            {
                path: "",
                name: "catalogHome",
                component: () => import("@/Pages/Catalog/Index.vue"),
            },
            {
                path: "categories/:id",
                name: "categories",
                props: true,
                component: () => import("@/Pages/Catalog/Categories/Index.vue"),
            },
            {
                path: "product/:id",
                name: "product",
                props: true,
                component: () => import("@/Pages/Catalog/Products/Show.vue"),
            },
        ],
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
    await userStore.getUser();

    const user = userStore.user;

    if (to.meta.requiresAuth && !user) {
        return { name: "fallback", query: { type: "unAuthorized" } };
    }
});

export default router;
