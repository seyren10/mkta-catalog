<template>
    <ZTELayout>
        <template #toolbar>
            <div class="grow">
                <span></span>
            </div>
        </template>
        <template #sidebar>
            <div class="p-3">
                <div class="flex items-center gap-2">
                    <img src="/Logo.svg" alt="" class="max-w-[5rem]" />
                    <v-heading type="h3" class="text-slate-600"
                        >Admin Panel</v-heading
                    >
                </div>
                <hr class="my-2" />
                <div class="mb-4 flex gap-3 rounded-lg bg-stone-200 p-2">
                    <div class="max-w-[4rem] rounded-full bg-white">
                        <img src="/mk-images/hero-images/7.png" alt="" />
                    </div>
                    <div>
                        <div class="font-bold">{{ currentUser.name }}</div>
                        <span class="text-[.8rem] text-slate-400">{{
                            currentUser.role_data.title
                        }}</span>
                    </div>
                </div>

                <VRouteNav
                    title="Content Management"
                    :items="contentManagement"
                />

                <VRouteNav
                    :title="'User Management'"
                    :items="user_management"
                />

                <VRouteNav
                    v-if="true"
                    :title="'Product Management'"
                    :items="product_management"
                />
                <VRouteNav
                    v-if="true"
                    :title="'Customer Management'"
                    :items="cutomer_management"
                />
                <!-- <VRouteNav
                    v-if="true"
                    :title="'Content Management'"
                    :items="cms_management"
                /> -->
                <VRouteNav
                    v-if="true"
                    :title="'Others'"
                    :items="file_management"
                />
            </div>
        </template>

        <div class="bg-white p-3">
            <!-- <VHotLinks class="mb-2" /> -->
            <RouterView v-slot="{ Component }">
                <template v-if="Component">
                    <Suspense timeout="0">
                        <component :is="Component" />

                        <template v-slot:fallback>
                            <Teleport to="#app">
                                <div
                                    class="absolute inset-0 grid place-content-center"
                                >
                                    <VLoader scale="2"></VLoader>
                                </div>
                            </Teleport>
                        </template>
                    </Suspense>
                </template>
            </RouterView>
        </div>
    </ZTELayout>
</template>

<script setup>
import { ref, watch, inject, computed } from "vue";
import ZTELayout from "./components/ZTELayout.vue";
import VRouteNav from "../components/VRouteNav.vue";
import VLoader from "../components/base_components/VLoader.vue";

import VHotLinks from "./components/AdminLayout/global/VHotLinks.vue";

//reactives
const user_management = [
    {
        title: "Users",
        to: "users",
        icon: "fa-users",
    },
    {
        title: "Permissions",
        to: "permissions",
        icon: "gi-checked-shield",
    },
    {
        title: "Roles",
        to: "rolesIndex",
        icon: "fa-user-cog",
    },
];
const cutomer_management = [
    {
        title: "Areas",
        to: "areasIndex",
        icon: "la-map-marked-alt-solid",
    },
    {
        title: "Companies",
        to: "companiesIndex",
        icon: "px-buildings",
    },
    {
        title: "Customers",
        to: "customerIndex",
        icon: "la-users-solid",
    },
];
const product_management = [
    {
        title: "Categories",
        to: "categoryIndex",
        icon: "md-category",
    },
    {
        title: "Product Item",
        to: "productItemIndex",
        icon: "bi-cart4",
    },
    {
        title: "Product Access types",
        to: "productAccessTypeIndex",
        icon: "ai-closed-access",
    },
    {
        title: "Filters",
        to: "productFilterIndex",
        icon: "hi-solid-filter",
    },
];
const file_management = [
    {
        title: "Files Manager",
        to: "fileIndex",
        icon: "fa-folder-open",
    },
    {
        title: "Icon Manager",
        to: "iconIndex",
        icon: "fa-shapes",
    },
];

const contentManagement = [
    {
        title: "Catalog Home",
        to: "cmsCatalog",
        icon: "fa-cogs",
    },
];
//provide/inject
const currentUser = inject("currentUser");
</script>

<style lang="scss" scoped></style>
