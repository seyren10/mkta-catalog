<template>
    <ZTELayout>
        <template #toolbar>
            <div>You can add whatever you want here...</div>
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

                <div class="mb-4 flex gap-3 rounded-md bg-stone-200 p-2">
                    <div class="max-w-[4rem] rounded-full bg-white">
                        <img src="/mk-images/hero-images/7.png" alt="" />
                    </div>
                    <div>
                        <div class="font-bold">User Name here</div>
                        <span class="text-[.8rem] text-slate-400"
                            >some description</span
                        >
                    </div>
                </div>

                <VRouteNav :items="items"></VRouteNav>
            </div>
        </template>

        <div class="p-3">
            <router-view></router-view>
        </div>
    </ZTELayout>
</template>

<script setup>
import ZTELayout from "./components/ZTELayout.vue";
import VRouteNav from "../components/VRouteNav.vue";

//reactives
const items = [
    {
        title: "Dashboard",
        to: "dashboard",
        icon: "la-heart",
    },
    {
        title: "Product Management",
        to: "products",
        icon: "pr-globe",
    },
    {
        title: "Customer Management",
        to: "products",
        icon: "pr-globe",
        children: [
            { title: "Customer Transactions" },
            { title: "Customer Transactions" },
        ],
    },
];
</script>

<style lang="scss" scoped></style>
