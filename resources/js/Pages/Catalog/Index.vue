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
            <FeaturedProducts
                :items="christmasProducts"
                titleIcon="ri-fire-line"
                title="Top selling"
            >
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
                :items="newProducts"
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

            <FeaturedProducts
                :items="animalProducts"
                titleIcon="bi-snow"
                title="Seasonal"
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
                                class="text-[min(4vw_+_.5rem,_2rem)] font-medium tracking-wide text-primary"
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

        <!-- <v-card density="comfortable">
            <template #header>
                <header
                    class="grid min-h-[10rem] rounded-lg bg-[url('/mk-images/inlitefi.jpg')] bg-cover bg-center bg-no-repeat text-white"
                >
                    <div class="self-end p-4">
                        <h2 class="text-[1.3rem] font-medium tracking-wide">
                            A Heading with background Image
                        </h2>
                        <p class="font-light text-slate-200">
                            If you can read this, you are gay.
                        </p>
                    </div>
                </header>
            </template>
            <div>
                We are the champion. Lorem, ipsum dolor sit amet consectetur
                adipisicing elit. Doloribus earum laudantium soluta eveniet, id
                dolorum praesentium quia, facilis sit, ab et beatae optio est
                officiis exercitationem ut tenetur? Nam, ea.
            </div>
            <template #action>
                <v-button
                    class="text-accent"
                    outlined
                    prepend-inner-icon="pr-send"
                    icon-size="1"
                    >See More</v-button
                >
            </template>
        </v-card>
        <v-text-field v-model="search"> </v-text-field>
        <v-data-table
            :items="items"
            :search="search"
            class="my-3"
            striped
            density="comfortable"
        ></v-data-table>
        <v-text-on-image
            image="/carousel-test/eeq.jpg"
            title="This is it"
            subtitle="shop now and get debunked."
        >
            <template #overlay-title="{ title }">
                <h1 class="text-red-500">{{ title }}</h1>
            </template>
        </v-text-on-image> -->
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useProductStore } from "../../stores/productStore";
import { useCategoryStore } from "@/stores/categoryStore";

import FeaturedProducts from "./components/FeaturedProducts.vue";
import Product from "../../components/Product.vue";

//stores
const productStore = useProductStore();
const { getProductsWithCategoryId, getNewProducts } = productStore;
const christmasProducts = getProductsWithCategoryId(1);
const animalProducts = getProductsWithCategoryId(5);
const newProducts = getNewProducts(10);

const categoryStore = useCategoryStore();
const categories = categoryStore.categories;

//reactives
const items = ref(null);

//async
await fetch("https://jsonplaceholder.typicode.com/todos")
    .then((res) => res.json())
    .then((json) => (items.value = json));
</script>

<style lang="scss" scoped></style>
