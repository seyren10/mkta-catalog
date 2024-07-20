// adminRouter.js
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { MdChildcareTwotone } from "oh-vue-icons/icons";

const user_management = [
    {
        path: "users",
        name: "users",
        component: () => import("@/Pages/Admin/Users/Index.vue"),
        meta: {
            title: "Users",
            description: "List of users and its role to the System.",
        },
    },
    {
        path: "users/:id",
        name: "userShow",
        props: true,
        component: () => import("@/Pages/Admin/Users/Show.vue"),
        meta: {
            title: "Users",
            description: "List of users and its role to the System.",
            redirectTo: "users",
        },
    },
    {
        path: "permissions",
        name: "permissions",
        component: () => import("@/Pages/Admin/Permissions/Index.vue"),
        meta: {
            title: "Permissions",
            description:
                "Efficiently manage access control and ensure data security within the Catalog.",
        },
    },
    {
        path: "roles",
        name: "rolesIndex",
        component: () => import("@/Pages/Admin/Roles/Index.vue"),
        meta: {
            title: "Roles",
            description:
                "Efficiently manage access control and ensure data security within the Catalog.",
        },
    },
    {
        path: "roles/:id",
        name: "roleShow",
        props: true,
        component: () => import("@/Pages/Admin/Roles/Show.vue"),
        meta: {
            title: "Roles",
            description:
                "Efficiently manage access control and ensure data security within the Catalog.",
            redirectTo: "rolesIndex",
        },
    },
];

const customer_management = [
    {
        path: "/customers",
        name: "customerIndex",
        component: () => import("@/Pages/Admin/Customers/Index.vue"),
        meta: {
            title: "Customers",
            description:
                "List of Customers of MK Themed Attractions Inc - Philippines.",
        },
    },
    {
        path: "customers/:id",
        name: "customerShow",
        props: true,
        component: () => import("@/Pages/Admin/Customers/Show.vue"),
        meta: {
            title: "Customers",
            description:
                "List of Customers of MK Themed Attractions Inc - Philippines.",
            redirectTo: "customerIndex",
        },
    },
    {
        path: "areas",
        name: "areasIndex",
        component: () => import("@/Pages/Admin/Areas/Index.vue"),
        meta: {
            title: "Areas",
            description:
                "List of Global Areas in which the MK Themed Attractions Inc - Philippines operates.",
        },
    },
    {
        path: "companies",
        name: "companiesIndex",
        component: () => import("@/Pages/Admin/Companies/Index.vue"),
        meta: {
            title: "Companies",
            description:
                "List of Partners of MK Themed Attractions Inc - Philippines.",
        },
    },
];

const product_management = [
    {
        path: "categories",
        name: "categoryIndex",
        component: () => import("@/Pages/Admin/Categories/Index.vue"),
        meta: {
            title: "Categories",
            description: "List of categories for the Products",
        },
    },
    {
        path: "categories/:id",
        name: "categoryShow",
        props: true,
        component: () => import("@/Pages/Admin/Categories/Show.vue"),
        meta: {
            title: "Categories",
            description: "List of categories for the Products",
            redirectTo: "categoryIndex",
        },
    },

    {
        path: "product-item",
        name: "productItemIndex",
        component: () => import("@/Pages/Admin/Products/Index.vue"),
        meta: {
            title: "Product Item",
            description: "List of Products",
        },
    },
    {
        path: "product-item/:id",
        name: "productItemShow",
        props: true,
        component: () => import("@/Pages/Admin/Products/Show.vue"),
        meta: {
            title: "Product Item",
            description: "List of Products",
            redirectTo: "productItemIndex",
        },
    },

    {
        path: "product-access-types",
        name: "productAccessTypeIndex",
        component: () => import("@/Pages/Admin/ProductAccessType/Index.vue"),
        meta: {
            title: "Product Access Types",
            description: "List of Access types of the Products",
        },
    },
    {
        path: "product-access-types/:id",
        props: true,
        name: "productAccessTypeShow",
        component: () => import("@/Pages/Admin/ProductAccessType/Show.vue"),
        meta: {
            title: "Product Access Types",
            description: "List of Access types of the Products",
            redirectTo: "productAccessTypeIndex",
        },
    },

    {
        path: "product-filter",
        name: "productFilterIndex",
        component: () => import("@/Pages/Admin/Filter/Index.vue"),
        meta: {
            title: "Product Filters",
            description: "List of Filter for the Products",
        },
    },
    {
        path: "product-filter/:id",
        name: "productFilterShow",
        props: true,
        component: () => import("@/Pages/Admin/Filter/Show.vue"),
        meta: {
            title: "Product Filter",
            description: "List of Filter for the Products",
            redirectTo: "productFilterIndex",
        },
    },
];

const file_management = [
    {
        path: "files",
        name: "fileIndex",
        component: () => import("@/Pages/Admin/Files/Index.vue"),
        meta: {
            title: "File Management",
            description: "List of Files uploaded in the Resources Storage",
        },
    },
    {
        path: "icons",
        name: "iconIndex",
        component: () => import("@/Pages/Admin/Icons/Index.vue"),
        meta: {
            title: "Icon Management",
            description: "List of icons that can be used in the system",
        },
    },
];

const contentManagement = [
    {
        path: "catalog",
        name: "cmsCatalog",
        component: () => import("@/Pages/Admin/CMS/Catalog/CMSCatalog.vue"),
    },
];

const admin_routes = [
    {
        path: "/admin",
        name: "admin",
        component: AdminLayout,
        meta: {
            requiresAuth: true,
        },
        children: [
            ...user_management,
            ...customer_management,
            ...product_management,
            ...file_management,
            ...contentManagement,
        ],
    },
];

export default admin_routes;
