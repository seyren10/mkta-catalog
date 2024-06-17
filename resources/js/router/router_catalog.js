// adminRouter.js
import CatalogLayout from "@/Layouts/CatalogLayout.vue";

const catalog_routes =[
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
];

export default catalog_routes;