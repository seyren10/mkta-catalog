// adminRouter.js
import AdminLayout from "@/Layouts/AdminLayout.vue";

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
                path: "dashboard",
                name: "dashboard",
                component: () => import("@/Pages/Admin/Dashboard/Index.vue"),
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
            }
        ],
    }
];

export default admin_routes;