<template>
    <div class="container my-8 space-y-5" v-if="!loading">
        <header
            class="grid items-center gap-5 overflow-hidden rounded-lg bg-white p-10 md:grid-cols-2 md:grid-rows-[min-content_auto]"
        >
            <div class="md:col-span-2">
                <BreadCrumb
                    :items="[
                        { name: 'catalog', text: 'Catalog' },
                        { name: 'categories', text: 'Categories' },
                    ]"
                ></BreadCrumb>
            </div>
            <div
                class="aspect-video overflow-hidden rounded-lg bg-slate-200 md:order-2"
            >
                <v-text-on-image
                    no-overlay
                    :image="`/api/s3-resources/${category.img}`"
                    class="h-full w-full object-cover"
                />
            </div>
            <div>
                <h1
                    class="my-5 text-head font-light uppercase tracking-wide text-primary"
                >
                    {{ category?.title }}
                </h1>
                <p class="max-w-[50ch] text-slate-500 md:order-1">
                    {{ category?.description }}
                </p>
            </div>
        </header>
        <nav>
            <ul class="flex flex-wrap gap-3">
                <li
                    v-for="item in category.sub_categories"
                    class="min-w-fit rounded-lg bg-slate-300 px-3 py-1 text-[.75rem] text-slate-500"
                >
                    {{ item.title }}
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
                        no-overlay
                        class="overflow-hidden rounded-lg bg-slate-100"
                        v-for="product in products"
                        :item="product"
                        :key="product.id"
                    ></Product>
                </template>

                <template #footer>
                    <div
                        class="flex flex-wrap justify-center gap-2 rounded-lg bg-white p-2"
                    >
                        <v-button
                            outlined
                            v-for="(page, index) in paginationLinks"
                            :class="{
                                'bg-accent text-white': page.active,
                            }"
                            :disabled="page.url === null"
                            @click="handlePageChange(page)"
                        >
                            <v-icon
                                v-if="index === 0"
                                name="md-keyboardarrowleft-round"
                            ></v-icon>
                            <v-icon
                                v-else-if="index === paginationLinks.length - 1"
                                name="md-keyboardarrowright-round"
                            ></v-icon>
                            <span v-else>
                                {{ page.label }}
                            </span>
                        </v-button>
                    </div>
                </template>
            </ProductListing>
        </main>
    </div>
    <div v-else class="absolute inset-0 grid place-content-center">
        <VLoader scale="2"></VLoader>
    </div>
</template>

<script setup>
import { inject, onBeforeMount, ref } from "vue";
import { storeToRefs } from "pinia";
import { onBeforeRouteUpdate, useRouter } from "vue-router";
import { useQuery } from "../../../composables/useQuery";

import BreadCrumb from "@/components/BreadCrumb.vue";
import ProductListing from "./components/ProductListing.vue";
import Filter from "./components/Filter.vue";
import Product from "@/components/Product.vue";
import VLoader from "../../../components/base_components/VLoader.vue";

const props = defineProps({
    id: String,
});

//stores
const categoryStore = inject("categoryStore");
const category = ref(null);
const productStore = inject("productStore");
const { product_items: products, paginationLinks } = storeToRefs(productStore);

const getProductsWithCategoryId = productStore.getProductItemsWithCategoryId;
const loading = ref(false);
const router = useRouter();
const sortBy = ref(0);

const [page, setPage] = useQuery("page", () => fetchProducts(+props.id));

//methods

async function fetchProducts(categoryId) {
    loading.value = true;

    category.value = categoryStore.getCategoryWithId(+props.id);
    await getProductsWithCategoryId(+categoryId, {
        includeProductImages: true,
        page: page.value,
    });

    loading.value = false;
}

const handlePageChange = (page) => {
    if (page.url === null) return;

    const pageNumber = page.url.match(/[?&]page=(\d+)/)?.at(1);

    setPage(+pageNumber);
};

//hooks
onBeforeRouteUpdate(async (to, from) => {
    if (to.params.id !== from.params.id) await fetchProducts(to.params.id);
});

//incase user manualy set the category URL of category ID to something else
//that doesnt exist in the database
onBeforeMount(async () => {
    category.value = categoryStore.getCategoryWithId(+props.id);

    if (!category.value) {
        router.push({ name: "fallback" });
    }

    await fetchProducts(+props.id);
});
</script>

<style lang="scss" scoped></style>
