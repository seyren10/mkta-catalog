<template>
    <div
        class="relative grid min-h-[30rem] grid-rows-[auto,1fr,auto] items-start space-y-3 p-3"
    >
        <CMSFPDialogToolbar @change="handleChange" class="sticky top-0 z-10">
            <template #default="{ data }">
                <div class="flex items-center gap-2">
                    <div class="text-slate-500">
                        {{ pagination.current_page }} of
                        {{ pagination.last_page }}
                    </div>

                    <div class="flex text-slate-500">
                        <v-button
                            icon="md-keyboarddoublearrowleft-round"
                            @click="gotoFirstPage(data)"
                        ></v-button>
                        <v-button
                            icon="md-keyboardarrowleft-round"
                            @click="prevPage(data)"
                        ></v-button>
                        <v-button
                            icon="md-keyboardarrowright-round"
                            @click="nextPage(data)"
                        ></v-button>
                        <v-button
                            icon="md-keyboarddoublearrowright-round"
                            @click="gotoLastPage(data)"
                        ></v-button>
                    </div>
                </div>
            </template>
        </CMSFPDialogToolbar>

        <div v-if="!productLoading">
            <ul class="grid gap-3 md:grid-cols-6" v-if="viewingProducts.length">
                <li v-for="product in viewingProducts" :key="product.id">
                    <div
                        class="relative grid aspect-square cursor-pointer justify-center gap-3 rounded-lg bg-slate-200 p-3"
                        @click="addToSelected(product)"
                    >
                        <v-text-on-image
                            :image="
                                s3(product.product_thumbnail?.file.filename)
                            "
                            no-overlay
                        ></v-text-on-image>
                        <p class="line-clamp-2 self-end text-center">
                            {{ product.title }}
                        </p>

                        <v-icon
                            v-if="existInSelected(product)"
                            name="bi-check"
                            class="absolute left-2 top-2 rounded-full bg-green-500 text-white"
                            scale="1"
                        ></v-icon>
                    </div>
                </li>
            </ul>
            <div v-else class="text-center">No Product found.</div>
        </div>
        <div v-else class="g rid place-content-center">
            <VLoader></VLoader>
        </div>

        <div
            class="sticky bottom-2 z-10 flex items-center justify-between gap-3 rounded-lg bg-slate-100 p-3"
        >
            <div class="flex items-center gap-3">
                <span>
                    <strong>{{ selectedCount }} </strong> selected</span
                >

                <v-checkbox
                    label="view selected"
                    v-model="viewSelected"
                ></v-checkbox>
            </div>

            <div class="flex gap-1">
                <v-button
                    prepend-inner-icon="bi-list-check"
                    class="text-xs"
                    @click="selectAll"
                    >Select All</v-button
                >

                <v-button
                    prepend-inner-icon="la-times-solid"
                    class="text-xs"
                    icon-size=".9"
                    @click="unSelectAll"
                    >Unselect All</v-button
                >
            </div>
        </div>
    </div>
</template>

<script setup>
import { storeToRefs } from "pinia";
import { useProductStore } from "../../../../../stores/productStore";
import { computed, inject, ref } from "vue";

import CMSFPDialogToolbar from "./CMSFPDialogToolbar.vue";
import VLoader from "@/components/base_components/VLoader.vue";

const {
    products,
    pagination,
    nextPage,
    prevPage,
    gotoFirstPage,
    gotoLastPage,
    loading: productLoading,
    getProducts,
    page,
} = useProducts();

const {
    addToSelected,
    existInSelected,
    selectedCount,
    selectAll,
    unSelectAll,
    selectedProducts,
} = useSelectedProducts(products);
const s3 = inject("s3");
const viewSelected = ref(false);

const viewingProducts = computed(() => {
    if (viewSelected.value) {
        return selectedProducts.value;
    } else {
        return products.value;
    }
});

function handleChange(data) {
    page.value = 1;
    getProducts(data);
}

function useProducts() {
    const productStore = useProductStore();

    const page = ref(1);
    const perPage = ref(100);

    const {
        product_items: products,
        paginationLinks,
        pagination,
        loading,
    } = storeToRefs(productStore);

    if (!products.value.length) {
        getProducts({ selected: -1 });
    }

    async function getProducts(options) {
        if (options.selected === -1) {
            //retrieve all products
            await productStore.getProductItems({
                q: options.search,
                perPage: perPage.value,
                page: page.value,
            });
        } else {
            //retrieve products by category
            await productStore.getProductItemsWithCategoryId(options.selected, {
                q: options.search,
                soryBy: "newest-first",
                perPage: perPage.value,
                page: page.value,
            });
        }
    }

    function nextPage(data) {
        if (page.value < pagination.value.last_page) {
            page.value++;
            getProducts(data);
        } else {
            gotoFirstPage(data);
        }
    }

    function gotoFirstPage(data) {
        if (page.value === 1) return;

        page.value = 1;
        getProducts(data);
    }

    function gotoLastPage(data) {
        if (page.value === pagination.value.last_page) return;
        page.value = pagination.value.last_page;
        getProducts(data);
    }

    function prevPage(data) {
        if (page.value > 1) {
            page.value--;
            getProducts(data);
        } else {
            gotoLastPage(data);
        }
    }

    return {
        products,
        paginationLinks,
        pagination,
        nextPage,
        prevPage,
        gotoFirstPage,
        gotoLastPage,
        loading,
        getProducts,
        page,
    };
}

function useSelectedProducts(products) {
    const selectedProducts = ref([]);

    function existInSelected(product) {
        return selectedProducts.value.find((p) => p.id === product.id);
    }

    function addToSelected(product) {
        if (existInSelected(product)) {
            selectedProducts.value = selectedProducts.value.filter(
                (p) => p.id !== product.id,
            );
        } else {
            selectedProducts.value.push(product);
        }
    }

    function selectAll() {
        selectedProducts.value = [...selectedProducts.value, ...products.value];
        selectedProducts.value = Array.from(
            new Map(
                selectedProducts.value.map((product) => [product.id, product]),
            ).values(),
        );
    }
    function unSelectAll() {
        selectedProducts.value = [];
    }

    const selectedCount = computed(() => {
        return selectedProducts.value.length;
    });

    return {
        selectedProducts,
        addToSelected,
        existInSelected,
        selectedCount,
        selectAll,
        unSelectAll,
    };
}
</script>

<style lang="scss" scoped></style>
