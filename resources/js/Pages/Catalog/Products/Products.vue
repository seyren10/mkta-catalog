<template>
    <section class="container my-8">
        <h1 class="mb-5 text-lg">
            We found <strong>{{ totalPages }}</strong> result for "<strong>{{
                query
            }}</strong
            >"
        </h1>
        <div
            class="grid grid-cols-2 gap-3 rounded-lg bg-white p-3 md:grid-cols-4 lg:grid-cols-5"
        >
            <Product
                no-overlay
                v-for="product in products"
                :item="product"
                class="rounded-lg bg-slate-100"
                v-if="productCount"
            ></Product>
            <div
                v-else-if="!productCount && !loading"
                class="col-[1/-1] mx-auto flex w-[50ch] items-center justify-center gap-3 text-slate-500"
            >
                <v-icon name="la-search-solid" scale="1.3"></v-icon>
                It seems we don't have the product you're searching for. Please
                try searching for another product or contact our sales support.
            </div>
            <div
                class="col-[1/-1] flex items-center justify-center gap-3"
                v-if="loading"
            >
                <VLoader></VLoader>
                <span>Searching</span>
            </div>
        </div>
        <PaginationLinks
            :items="paginationLinks"
            @page-change="handlePageChange"
        ></PaginationLinks>
    </section>
</template>

<script setup>
import { useQuery } from "@/composables/useQuery";
import { useProductStore } from "../../../stores/productStore";
import { storeToRefs } from "pinia";
import { computed, ref } from "vue";

import Product from "@/components/Product.vue";
import VLoader from "../../../components/base_components/VLoader.vue";
import PaginationLinks from "@/components/PaginationLinks.vue";

const [query, setQuery] = useQuery("q", handleSearchProducts, true);
const [page, setPage] = useQuery("page", handleSearchProducts);
const productStore = useProductStore();
const {
    product_items: products,
    paginationLinks,
    totalPages,
} = storeToRefs(productStore);
const loading = ref(false);

const productCount = computed(() => products.value.length);

await handleSearchProducts(query.value);

async function handleSearchProducts(value) {
    products.value = [];

    try {
        loading.value = true;
        await productStore.getProductItems({
            q: query.value,
            includeProductImages: true,
            includeProductCategories: true,
            page: page.value,
        });
    } catch (e) {
    } finally {
        loading.value = false;
    }
}

const handlePageChange = (page) => {
    if (page.url === null) return;

    const pageNumber = page.url.match(/[?&]page=(\d+)/)?.at(1);

    setPage(+pageNumber);
};
</script>

<style lang="scss" scoped></style>
