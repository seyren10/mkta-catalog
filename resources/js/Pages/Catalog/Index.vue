<template>
    <div class="container my-8 space-y-10">
        <div class="grid gap-3 md:grid-cols-[1fr_auto]">
            <v-image-carousel
                class="row-span-2 aspect-[2/1]"
                :items="[
                    '/carousel-test/carousel-1.jpg',
                    '/carousel-test/carousel-2.jpg',
                    '/carousel-test/carousel-3.jpg',
                ]"
            >
            </v-image-carousel>

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

        <section class="space-y-10">
            <FeaturedProducts
                :items="christmasProducts"
                titleIcon="ri-fire-line"
                title="Top selling"
            >
            </FeaturedProducts>

            <FeaturedProducts
                :items="newProducts"
                titleIcon="md-newreleases-outlined"
                title="New Arrivals"
            >
                <template #overlay="data">
                    <span
                        class="absolute left-0 top-0 bg-red-500 p-1 text-[.7rem] text-white [border-bottom-right-radius:.5rem]"
                        >new</span
                    >

                    ></template
                >
                <template #content.icon="{ item }">
                    <div
                        v-bind="item"
                        class="rounded-md bg-red-500 px-1 text-[.7rem] text-white"
                    >
                        MK Mall
                    </div>
                </template>
            </FeaturedProducts>

            <FeaturedProducts
                :items="productStore.products"
                titleIcon="oi-star"
                title="all products"
            >
                <template #content.icon="{ item }">
                    <div :class="item.class"></div>
                </template>
            </FeaturedProducts>
        </section>

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

import FeaturedProducts from "./components/FeaturedProducts.vue";

//stores
const productStore = useProductStore();
const { getProductsWithCategoryId, getNewProducts } = productStore;
const christmasProducts = getProductsWithCategoryId(1);
const newProducts = getNewProducts(10);

const items = ref(null);

await fetch("https://jsonplaceholder.typicode.com/todos")
    .then((res) => res.json())
    .then((json) => (items.value = json));
</script>

<style lang="scss" scoped></style>
