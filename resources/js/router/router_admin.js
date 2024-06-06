// adminRouter.js
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { MdChildcareTwotone } from "oh-vue-icons/icons";

const admin_routes = [
    {
        path: "/admin",
        name: "admin",
        component: AdminLayout,
        meta: {
            requiresAuth: true,
        },
        children: [
            {
                path: "users",
                name: "users",
                component: () => import("@/Pages/Admin/Users/Index.vue"),
                children: [
                    {
                        path: "users",
                        name: "users",
                        component: () =>
                            import("@/Pages/Admin/Users/Index.vue"),
                    },
                ],
            },
            {
                path: "permissions",
                name: "permissions",
                component: () => import("@/Pages/Admin/Permissions/Index.vue"),
            },
            {
                path: "roles",
                name: "roles",
                component: () => import("@/Pages/Admin/Roles/Index.vue"),
            },

            {
                path: "products",
                name: "products",
                component: () => import("@/Pages/Admin/Products/Index.vue"),
            },
            {
                path: "/categories",
                name: "categories",
                component: () => import("@/Pages/Admin/Categories/Index.vue"),
            },
        ],
    },
];

export default admin_routes;
