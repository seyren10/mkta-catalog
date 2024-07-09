<template>
    <div class="container my-8 space-y-10">
        <!-- #region hero -->
        <div class="grid gap-3 md:grid-cols-[1fr_auto]">
            <v-horizontal-scroller
                class="row-span-2"
                auto-scroll
                :items="[
                    '/carousel-test/carousel-1.jpg',
                    '/carousel-test/carousel-2.jpg',
                    '/carousel-test/carousel-3.jpg',
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
                image="/carousel-test/10416177.jpg"
                class="aspect-[3/1] h-full min-w-full rounded-lg object-cover md:max-w-[25rem]"
                no-overlay
            />
            <v-text-on-image
                image="/carousel-test/eeq.jpg"
                class="aspect-[3/1] h-full min-w-full rounded-lg object-cover md:max-w-[25rem]"
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
            <FeaturedProducts titleIcon="ri-fire-line" title="Top selling">
                <template #content.icon="{ item }">
                    <div
                        :class="item.class"
                        class="rounded-md bg-red-500 px-1 text-[.7rem] text-white"
                    >
                        16% off
                    </div>
                </template>
            </FeaturedProducts>

            <FeaturedProducts
                titleIcon="md-newreleases-outlined"
                title="New Arrivals"
            >
                <template #content.icon="{ item }">
                    <div
                        :class="item.class"
                        class="rounded-md bg-accent px-1 text-[.7rem] text-white"
                    >
                        MK Mall
                    </div>
                </template>
            </FeaturedProducts>

            <FeaturedProducts titleIcon="bi-snow" title="Seasonal">
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
    </div>
</template>

<script setup>
import { inject, ref } from "vue";
import { useProductStore } from "../../stores/productStore";

import FeaturedProducts from "./components/FeaturedProducts.vue";
import { storeToRefs } from "pinia";

//stores
const productStore = useProductStore();
const { categories } = storeToRefs(inject("categoryStore"));

//reactives

//async
</script>

<style lang="scss" scoped></style>
