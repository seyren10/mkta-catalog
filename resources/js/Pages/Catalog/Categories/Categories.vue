<template>
    <div class="container my-8">
        <header
            class="grid gap-5 overflow-hidden rounded-lg bg-white p-5 md:grid-cols-2 md:grid-rows-[min]"
        >
            <div class="row-start-1 md:col-[1/-1]">
                <BreadCrumb
                    :items="[
                        { name: 'catalog', text: 'Catalog' },
                        { name: 'categories', text: 'Categories' },
                    ]"
                ></BreadCrumb>
            </div>

            <div class="col-span-2">
                <v-text-on-image
                    :image="bannerImage"
                    no-overlay
                    class="aspect-[4/1]"
                ></v-text-on-image>
            </div>
        </header>
        <nav class="mt-8">
            <ul class="flex flex-wrap gap-3">
                <li
                    v-for="item in category.sub_categories"
                    class="min-w-fit rounded-lg bg-slate-300 px-3 py-1 text-[.75rem] text-slate-500"
                >
                    {{ item.title }}
                </li>
            </ul>
        </nav>
        <main class="mt-8">
            <ProductListing :loading="loading">
                <template #aside>
                    <Filter @change="fetchProducts(id)"></Filter>
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
                        class="overflow-hidden rounded-lg bg-primary text-white"
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

const s3 = inject("s3");

//stores
const categoryStore = inject("categoryStore");
const { category } = storeToRefs(categoryStore);
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

    await categoryStore.getCategoryWithId(+categoryId);

    const queriesExceptPage = Object.keys(route.query).reduce((acc, query) => {
        /* add queries that is not 'page' key and its value is not empty */
        if (query !== "page" && route.query[query].trim() !== "") {
            acc[query] = route.query[query];
        }

        return acc;
    }, {});

    await getProductsWithCategoryId(+categoryId, {
        includeProductImages: true,
        includeProductFilter: true,
        page: page.value,
        filters: queriesExceptPage,
    });

    loading.value = false;
};

const bannerImage = computed(() => {
    return s3(category.value.banner_file?.filename);
});
const handlePageChange = (page) => {
    if (page.url === null) return;

    const pageNumber = page.url.match(/[?&]page=(\d+)/)?.at(1);

    setPage(+pageNumber);
};

await fetchProducts(+props.id);
</script>

<style lang="scss" scoped></style>
