// adminRouter.js
import { useCategoryStore } from "@/stores/categoryStore";
import { useProductStore } from "@/stores/productStore";

import CatalogLayout from "@/Layouts/CatalogLayout.vue";
import { storeToRefs } from "pinia";

const catalog_routes = [
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

                component: () =>
                    import("@/Pages/Catalog/Categories/Categories.vue"),

                beforeEnter: async (to, from) => {
                    //fetch categories before entering this route

                    const categoryStore = useCategoryStore();
                    const { categories } = storeToRefs(categoryStore);

                    if (!categories.value.length)
                        await categoryStore.getCategories({
                            includeSubCategories: true,
                            includeParentCategory: true,
                            includeFile: true,
                            includeBannerImage: true,
                        });

                    //redirect the user to not found page when
                    //they manually typed category ids that doesnt exist
                    const category = categoryStore.getCategoryWithId(
                        +to.params.id,
                    );
                    if (!category) {
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
                },
            },
            {
                path: "products",
                name: "products",
                component: () =>
                    import("@/Pages/Catalog/Products/Products.vue"),
            },
            {
                path: "product/:id",
                name: "product",
                props: true,
                component: () => import("@/Pages/Catalog/Products/Show.vue"),

                beforeEnter: async (to, from) => {
                    //fetch products before entering to the route

                    const productStore = useProductStore();
                    const { product_item: product } = storeToRefs(productStore);
                    await productStore.getProductItem(to.params.id);

                    //redirect the user to not found page when
                    //they manually typed category ids that doesnt exist

                    if (!product.value) {
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
                },
            },
            {
                path: "profile",
                name: "profile",
                component: () => import("@/Pages/Catalog/Profile/Profile.vue"),
                meta: {
                    fullUserData: true,
                },
            },
        ],
    },
];

export default catalog_routes;
