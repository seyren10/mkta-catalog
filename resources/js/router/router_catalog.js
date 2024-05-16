// adminRouter.js
import CatalogLayout from "@/Layouts/CatalogLayout.vue";

const catalog_routes =[
        {
                path: "/catalog",
                name: "catalog",
                component: CatalogLayout,
                meta: {
                        requiresAuth: true,
                },
                children: [
                ],
        }
];

export default catalog_routes;