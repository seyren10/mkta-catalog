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
                        <div class="font-bold">{{ user.name }}</div>
                        <span class="text-[.8rem] text-slate-400">{{
                            user.role_data.title
                        }}</span>
                    </div>
                </div>
                <VRouteNav :items="items"></VRouteNav>
            </div>
        </template>

        <div class="bg-white p-3">
            <VHotLinks class="mb-2" />
            <router-view></router-view>
        </div>
    </ZTELayout>
</template>

<script setup>
import { ref, watch, inject, computed } from "vue";
import ZTELayout from "./components/ZTELayout.vue";
import VRouteNav from "../components/VRouteNav.vue";

import VHotLinks from "./components/AdminLayout/global/VHotLinks.vue"

//reactives
const items = [
    {
        title: "Dashboard",
        to: "admin",
        icon: "la-heart",
    },

    {
        title: "Categories",
        to: "categories",
        icon: "pr-globe",
    },
    {
        title: "Dashboard",
        to: "admin",
        icon: "la-heart",
    },

    {
        title: "Categories",
        to: "categories",
        icon: "pr-globe",
    },
    {
        title: "Dashboard",
        to: "admin",
        icon: "la-heart",
    },

    {
        title: "Categories",
        to: "categories",
        icon: "pr-globe",
    },
    {
        title: "Dashboard",
        to: "admin",
        icon: "la-heart",
    },

    {
        title: "Categories",
        to: "categories",
        icon: "pr-globe",
    },
    {
        title: "Dashboard",
        to: "admin",
        icon: "la-heart",
    },

    {
        title: "Categories",
        to: "categories",
        icon: "pr-globe",
    },
    {
        title: "Dashboard",
        to: "admin",
        icon: "la-heart",
    },

    {
        title: "Categories",
        to: "categories",
        icon: "pr-globe",
    },
    {
        title: "Dashboard",
        to: "admin",
        icon: "la-heart",
    },

    {
        title: "Categories",
        to: "categories",
        icon: "pr-globe",
    },
    {
        title: "Dashboard",
        to: "admin",
        icon: "la-heart",
    },

    {
        title: "Categories",
        to: "categories",
        icon: "pr-globe",
    },
    {
        title: "Dashboard",
        to: "admin",
        icon: "la-heart",
    },

    {
        title: "Categories",
        to: "categories",
        icon: "pr-globe",
    },
    {
        title: "Dashboard",
        to: "admin",
        icon: "la-heart",
    },

    {
        title: "Categories",
        to: "categories",
        icon: "pr-globe",
    },
    {
        title: "Dashboard",
        to: "admin",
        icon: "la-heart",
    },

    {
        title: "Categories",
        to: "categories",
        icon: "pr-globe",
    },
    {
        title: "Dashboard",
        to: "admin",
        icon: "la-heart",
    },

    {
        title: "Categories",
        to: "categories",
        icon: "pr-globe",
    },
    {
        title: "Dashboard",
        to: "admin",
        icon: "la-heart",
    },

    {
        title: "Categories",
        to: "categories",
        icon: "pr-globe",
    },
    {
        title: "Dashboard",
        to: "admin",
        icon: "la-heart",
    },

    {
        title: "Categories",
        to: "categories",
        icon: "pr-globe",
    },
    {
        title: "Dashboard",
        to: "admin",
        icon: "la-heart",
    },

    {
        title: "Categories",
        to: "categories",
        icon: "pr-globe",
    },
    // {
    //     title: "Customers",
    //     icon: "pr-send",
    //     children: [
    //         { title: "Transactions", to: "dashboard" },
    //         { title: "Purchase History", to: "products" },
    //         { title: "Mama mo pink", to: "dashboard" },
    //     ],
    // }
];

//provide/inject
const user = inject("user");
</script>

<style lang="scss" scoped></style>
