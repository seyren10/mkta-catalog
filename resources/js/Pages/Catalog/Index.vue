<template>
    <div class="container my-8 space-y-10">
        <!-- #region hero -->
        <div class="grid gap-3 md:grid-cols-[1fr_auto]">
            <v-horizontal-scroller
                class="row-span-2"
                auto-scroll
                :items="[
                    '/temp-images/1.jpg',
                    '/temp-images/2.jpg',
                    '/temp-images/3.webp',
                ]"
                item-size="100%"
            >
                <template #default="{ item }">
                    <div>
                        <v-text-on-image
                            :image="item"
                            no-overlay
                            class="aspect-[3/1]"
                        ></v-text-on-image>
                    </div>
                </template>
            </v-horizontal-scroller>

            <v-text-on-image
                image="/temp-images/4.jpg"
                class="aspect-[3/1] h-full rounded-lg md:max-w-[25rem]"
                no-overlay
            />
            <v-text-on-image
                image="/temp-images/5.jfif"
                class="aspect-[3/1] h-full rounded-lg object-cover md:max-w-[25rem]"
                subtitle="whitespace-nowrap overflow-hidden [text-overflow:ellipsis] mt-2 text-[.8rem] text-slate-300"
            >
                <template #overlay-title>
                    <div class="flex items-center gap-2">
                        <v-icon name="la-heart" class="fill-accent"></v-icon>
                        <span>Tap to shop more</span>
                    </div>
                </template>
            </v-text-on-image>
        </div>
        <!-- #endregion hero -->

        <!-- #region featured-products -->
        <section class="space-y-10">
            <FeaturedProducts
                titleIcon="ri-fire-line"
                title="Top selling"
                :items="topSellingProducts"
            >
                <template #content.icon="{ item }">
                    <div
                        :class="item.class"
                        class="flex items-center gap-1 rounded-md bg-red-500 px-1 text-[.7rem] text-white"
                    >
                        <v-icon name="ri-fire-line" scale=".7"></v-icon
                        ><strong>HOT</strong>
                    </div>
                </template>
            </FeaturedProducts>

            <FeaturedProducts
                titleIcon="md-newreleases-outlined"
                title="New Arrivals"
                :items="latestProducts"
            >
                <template #content.icon="{ item }">
                    <div :class="item.class">
                        <v-icon name="md-fibernew"></v-icon>
                    </div>
                </template>
            </FeaturedProducts>

            <FeaturedProducts
                titleIcon="bi-snow"
                title="Seasonal"
                :items="seasonalProducts"
            >
                <template #content.icon="{ item }">
                    <div :class="item.class"></div>
                </template>
            </FeaturedProducts>
        </section>
        <!-- #endregion -->

        <!-- #region subcategories -->
        <section>
            <v-horizontal-scroller
                scrim
                no-indicator
                columns="1"
                :items="categories"
                item-size="10rem"
                class="rounded-lg bg-white p-3"
            >
                <template #header>
                    <div class="grid md:grid-cols-2">
                        <div
                            class="m-auto max-w-[49ch] space-y-[1.5rem] self-start"
                        >
                            <h1
                                class="text-head font-medium tracking-wide text-primary"
                            >
                                Sub Categories
                            </h1>
                            <p>
                                Looking for something specific? We've got you
                                covered. Explore our wide range of products.
                            </p>
                        </div>
                        <div>
                            <img
                                src="/mk-images/astronaut-photo-op-removebg-preview.png"
                                alt=""
                                class="mx-auto max-w-full"
                            />
                        </div>
                    </div>
                </template>
                <template #default="{ item }">
                    <div class="min-w-[10rem] p-2">
                        <v-text-on-image
                            :image="item.img"
                            no-overlay
                            class="aspect-square"
                        >
                        </v-text-on-image>
                        <h3 class="mt-2 text-center">{{ item.name }}</h3>
                    </div>
                </template>
            </v-horizontal-scroller>
        </section>
        <!-- #endregion subcategories -->

        <v-dialog
            v-model="firstTimeLogin"
            max-width="500"
            persistent
            v-if="user.first_time_login"
        >
            <template #header="data">
                <div class="flex items-center justify-between p-4 pb-0">
                    <h3 class="font-medium">First time login</h3>
                    <v-button
                        icon="la-times-solid"
                        icon-size=".9"
                        v-bind="data"
                    ></v-button>
                </div>
            </template>
            <div class="p-4 text-sm">
                Hi {{ user.name }}, since this is your first time logging in, we
                recommend that you set your password immediately.
                <em class="text-xs text-slate-400">
                    ( or set it later by clicking on your profile )
                </em>
                <FirstTimeLoginForm class="mt-4 p-3"></FirstTimeLoginForm>
            </div>
        </v-dialog>
    </div>
</template>

<script setup>
import { inject, ref } from "vue";
import { storeToRefs } from "pinia";
import { useAxios } from "@/composables/useAxios";

import FeaturedProducts from "./components/FeaturedProducts.vue";
import FirstTimeLoginForm from "./FirstTimeLoginForm.vue";

//stores
const { categories } = storeToRefs(inject("categoryStore"));
const user = inject("currentUser");
const firstTimeLogin = ref(true);
const { loading, errors, exec } = useAxios();

//async
const latestProducts = ref(
    await exec("/api/product/latest").then((res) => res.data.data),
);
const topSellingProducts = ref(
    await exec("/api/product/random").then((res) => res.data.data),
);
const seasonalProducts = ref(
    await exec("/api/product/random", "get", { count: 30 }).then(
        (res) => res.data.data,
    ),
);
</script>

<style lang="scss" scoped></style>
