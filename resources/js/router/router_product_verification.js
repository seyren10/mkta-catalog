import ProductVerification from "@/Pages/ProductVerification/Index.vue";

const product_verification_routes = [
    {
        path: "/verify-product",
        name: "verifyProduct",
        component: ProductVerification,
        children: [
            {
                path: "information",
                name: "verifyProductInformation",
                component: () =>
                    import("@/Pages/ProductVerification/Info/Index.vue"),
            },
            {
                path: "category",
                name: "verifyProductCategory",
                component: () =>
                    import("@/Pages/ProductVerification/Category/Index.vue"),
            },
            {
                path: "images",
                name: "verifyProductImages",
                component: () =>
                    import("@/Pages/ProductVerification/Images/Index.vue"),
            },
        ],
    },
];

export default product_verification_routes;
