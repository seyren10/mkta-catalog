<template>
    <div class="container my-8 space-y-5">
        <header
            class="grid gap-5 overflow-hidden rounded-lg bg-white p-10 md:grid-cols-2 md:grid-rows-[min]"
        >
            <div class="row-start-1 md:col-[1/-1]">
                <BreadCrumb
                    :items="[
                        { name: 'catalog', text: 'Catalog' },
                        { name: 'categories', text: 'Categories' },
                    ]"
                ></BreadCrumb>
            </div>
            <div
                class="aspect-video overflow-hidden rounded-lg bg-slate-200 md:col-start-2 md:row-start-1 md:row-end-3"
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
                <p class="max-w-[50ch] text-slate-500">
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
            <ProductListing :loading="loading">
                <template #aside>
                    <Filter></Filter>
                </template>
                <template #top>
                    <div class="flex items-center justify-between">
                        <div class="text-[.8rem] text-slate-500">
                            <strong>{{ totalPages }}</strong> item(s) found for
                            "{{ category.title }}"
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
                    <PaginationLinks
                        :items="paginationLinks"
                        @page-change="handlePageChange"
                    ></PaginationLinks>
                </template>
            </ProductListing>
        </main>
    </div>
</template>

<script setup>
import { computed, inject, ref } from "vue";
import { storeToRefs } from "pinia";
import { useQuery } from "../../../composables/useQuery";
import { useRoute } from "vue-router";

import BreadCrumb from "@/components/BreadCrumb.vue";
import ProductListing from "./components/ProductListing.vue";
import Filter from "./components/Filter.vue";
import Product from "@/components/Product.vue";
import PaginationLinks from "../../../components/PaginationLinks.vue";

const props = defineProps({
    id: String,
});

//stores
const categoryStore = inject("categoryStore");
const category = ref(null);
const productStore = inject("productStore");
const route = useRoute();

const {
    product_items: products,
    paginationLinks,
    totalPages,
} = storeToRefs(productStore);

const getProductsWithCategoryId = productStore.getProductItemsWithCategoryId;
const loading = ref(false);
const sortBy = ref(0);

const [page, setPage] = useQuery("page", () => fetchProducts(+props.id));

const fetchProducts = async (categoryId) => {
    loading.value = true;

    category.value = categoryStore.getCategoryWithId(+categoryId);
    await getProductsWithCategoryId(+categoryId, {
        includeProductImages: true,
        includeProductFilter: true,
        page: page.value,
        filters: route.query,
    });

    loading.value = false;
};

const handlePageChange = (page) => {
    if (page.url === null) return;

    const pageNumber = page.url.match(/[?&]page=(\d+)/)?.at(1);

    setPage(+pageNumber);
};

await fetchProducts(+props.id);
</script>

<style lang="scss" scoped></style>
