<template>
    <div class="container my-8 space-y-5" v-if="category">
        <header
            class="grid items-center gap-5 overflow-hidden rounded-lg bg-white p-10 md:grid-cols-2 md:grid-rows-[min-content_auto]"
        >
            <div class="md:col-span-2">
                <BreadCrumb></BreadCrumb>
            </div>
            <div
                class="aspect-video overflow-hidden rounded-lg bg-red-500 md:order-2"
            >
                <img
                    :src="category.img"
                    alt=""
                    class="h-full w-full object-cover"
                />
            </div>
            <div>
                <h1
                    class="my-5 text-head font-light uppercase tracking-wide text-primary"
                >
                    {{ category?.name }}
                </h1>
                <p class="max-w-[50ch] text-slate-500 md:order-1">
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                    Vel eligendi ducimus reprehenderit voluptatum reiciendis
                    impedit quia eaque, deleniti magni velit.
                </p>
            </div>
        </header>
        <nav>
            <ul class="flex flex-wrap gap-3">
                <li
                    v-for="item in category.subCategories"
                    class="min-w-fit rounded-lg bg-slate-300 px-3 py-1 text-[.75rem] text-slate-500"
                >
                    {{ item }}
                </li>
            </ul>
        </nav>

        <main>
            <ProductListing>
                <template #aside>
                    <Filter></Filter>
                </template>
                <template #top>
                    <div class="flex items-center justify-between">
                        <div class="text-[.8rem] text-slate-500">
                            Showing 1 of 20 items
                        </div>
                        <div class="flex items-center gap-3">
                            <span>Sort By:</span>
                            <v-select
                                position="bottom"
                                v-model="sortBy"
                                :items="[
                                    { title: 'Newest first', id: 0 },
                                    { title: 'Popular', id: 1 },
                                    { title: 'Highest rated', id: 2 },
                                ]"
                            ></v-select>
                        </div>
                    </div>
                </template>
                <template #default>
                    <Product
                        class="overflow-hidden rounded-lg bg-slate-100"
                        v-for="product in products"
                        :item="product"
                        :key="product.id"
                    ></Product>
                </template>
            </ProductListing>
        </main>
    </div>
    <InpageNotFound v-else></InpageNotFound>
</template>

<script setup>
import { computed, ref } from "vue";
import { useCategoryStore } from "@/stores/categoryStore";
import { useProductStore } from "@/stores/productStore";

import BreadCrumb from "@/components/BreadCrumb.vue";
import InpageNotFound from "../../../components/InpageNotFound.vue";
import ProductListing from "./components/ProductListing.vue";
import Filter from "./components/Filter.vue";
import Product from "@/components/Product.vue";

const props = defineProps({
    id: String,
});

//stores
const categoryStore = useCategoryStore();
const { getCategoryWithId } = categoryStore;

const productStore = useProductStore();
const { getProductsWithCategoryId } = productStore;

const products = computed(() => getProductsWithCategoryId(+props.id));

const category = computed(() => {
    return getCategoryWithId(+props.id);
});

//reactives
const sortBy = ref(0);

//non-reactives
const tabData = [
    { title: "Tab 1", value: "tab1" },
    { title: "Tab 2", value: "tab2" },
    { title: "Tab 3", value: "tab3" },
];
</script>

<style lang="scss" scoped></style>
