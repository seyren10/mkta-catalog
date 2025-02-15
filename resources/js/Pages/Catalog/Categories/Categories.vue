<template>
    <div class="container my-4 space-y-4">
        <BreadCrumb
            class="flex lg:hidden"
            :items="[
                { name: 'catalog', text: 'Catalog' },
                { name: 'categories', text: 'Categories' },
            ]"
        ></BreadCrumb>
        <header class="relative overflow-hidden rounded-lg bg-white">
            <BreadCrumb
                class="absolute left-1 top-0 z-10 hidden text-white lg:flex"
                :items="[
                    { name: 'catalog', text: 'Catalog' },
                    { name: 'categories', text: 'Categories' },
                ]"
            ></BreadCrumb>

            <v-text-on-image
                :image="bannerImage"
                no-overlay
                class="aspect-[11/1] h-full"
            ></v-text-on-image>
        </header>
        <nav class="mt-2">
            <div class="flex flex-wrap gap-2">
                <button
                    @click="fetchProductsBySub(item)"
                    v-for="item in category.sub_categories"
                    class="min-w-fit rounded-lg px-3 py-2 text-[.75rem] text-slate-500"
                    :key="category.id + '-' + item.id"
                    :class="
                        route.query['sub'] == item.id
                            ? 'bg-red-300'
                            : 'bg-slate-300'
                    "
                >
                    {{ item.title }}
                </button>
            </div>
        </nav>
        <main class="mt-2">
            <ProductListing :loading="loading">
                <!-- <template #aside>
                    <div
                        class="mb-4 flex flex-col items-center justify-between"
                    >
                        <div class="text-[.8rem] text-slate-500">
                            <strong>{{ totalPages }}</strong> item(s) found for
                            "
                            {{ category.title }}
                            {{ route.query.sub ? ">" : "" }}
                            {{
                                category.sub_categories.find((subCat) => {
                                    return subCat.id == route.query.sub;
                                })?.title
                            }}
                            "
                        </div>
                        <div class="flex items-center gap-3">
                            <span>Sort By:</span>
                            <v-select
                                position="bottom"
                                v-model="sortBy"
                                :items="sortData"
                                item-value="value"
                            ></v-select>
                        </div>
                    </div>
                    <Filter @change="fetchProducts(id)"></Filter>
                </template> -->

                <!-- <template #top> </template> -->
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
import { computed, inject, onBeforeMount, ref, watch } from "vue";
import { storeToRefs } from "pinia";
import { useQuery } from "../../../composables/useQuery";
import { onBeforeRouteUpdate, useRouter, useRoute } from "vue-router";

import BreadCrumb from "@/components/BreadCrumb.vue";
import ProductListing from "./components/ProductListing.vue";
import Filter from "./components/Filter.vue";
import Product from "@/components/Product.vue";
import PaginationLinks from "../../../components/PaginationLinks.vue";

const router = useRouter();
const route = useRoute();

const props = defineProps({
    id: String,
});

const s3 = inject("s3");

//stores
const categoryStore = inject("categoryStore");
const { category } = storeToRefs(categoryStore);
const productStore = inject("productStore");

const {
    product_items: products,
    paginationLinks,
    totalPages,
} = storeToRefs(productStore);

const getProductsWithCategoryId = productStore.getProductItemsWithCategoryId;

const loading = ref(false);
const [page, setPage] = useQuery(
    "page",
    async () => await fetchProducts(+props.id),
);
const sortData = [
    {
        title: "Any order",
        id: 0,
        value: "any-order",
    },
    {
        title: "Newest First",
        id: 1,
        value: "newest-first",
    },
];
const { sortBy } = useSortBy((val) => fetchProducts(+props.id));

const bannerImage = computed(() => {
    return s3(category.value.banner_file?.filename);
});
const handlePageChange = (page) => {
    if (page.url === null) return;

    const pageNumber = page.url.match(/[?&]page=(\d+)/)?.at(1);

    setPage(+pageNumber);
};

const [sub, setSub] = useQuery("sub", async () => {
    await fetchProducts(category.value.id);
});

async function fetchProductsBySub(item) {
    router.push({
        name: "categories",
        params: { id: category.value.id },
        query: { sub: item.id },
    });
    // await setSub(item.id);
}

async function fetchProducts(categoryId) {
    loading.value = true;

    await categoryStore.getCategoryWithId(+categoryId);
    let queriesExceptPage = [];
    queriesExceptPage = Object.keys(route.query).reduce((acc, query) => {
        /* add queries that is not 'page' key and its value is not empty */
        if (["page", "sub"].includes(query)) {
            // Skip
            return acc;
        }
        if (route.query[query] !== "") {
            acc[query] = route.query[query];
        }
        return acc;
    }, {});
    await getProductsWithCategoryId(+categoryId, {
        includeProductCategoryKeys: true,
        includeProductImages: true,
        includeProductFilter: true,
        includeProductVolume: true,
        page: page.value,
        sub: sub.value,
        filters: queriesExceptPage,
        sortBy: sortBy.value,
    });

    loading.value = false;
}

function useSortBy(cb) {
    const sortBy = ref(null);

    watch(sortBy, (newValue) => {
        cb(newValue);
    });

    return { sortBy };
}

/* hooks */

onBeforeMount(async () => {
    sortBy.value = sortData.at(0).value;

    // await fetchProducts(+props.id);
});
</script>

<style lang="scss" scoped></style>
