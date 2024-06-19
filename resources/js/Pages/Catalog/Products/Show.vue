<template>
    <template v-if="product">
        <ProductView>
            <template #header>
                <ImageView></ImageView>
                <ProductInfo></ProductInfo>
            </template>
            <template #aside> <RecentViewed></RecentViewed> </template>
            <template #related>
                <RelatedProducts></RelatedProducts>
            </template>
        </ProductView>

        <LightBox
            v-model="lightbox"
            :items="productImages"
            :key="id"
        ></LightBox>
    </template>
    <InpageNotFound v-else></InpageNotFound>
</template>

<script setup>
import { computed, inject, onUpdated, provide, ref } from "vue";
import { useProductStore } from "../../../stores/productStore";

import InpageNotFound from "@/components/InpageNotFound.vue";
import LightBox from "@/components/LightBox/LightBox.vue";

import ProductView from "./components/ProductView.vue";
import ImageView from "./components/ImageView.vue";
import ProductInfo from "./components/ProductInfo.vue";
import RecentViewed from "./components/RecentViewed.vue";
import RelatedProducts from "./components/RelatedProducts.vue";

const props = defineProps({
    id: String,
});

//stores
const productStore = useProductStore();
const { getProductWithId } = productStore;

//injects
const categoryStore = inject("categoryStore");

//reactives
const currentImageIndex = ref(0);
const lightbox = ref(false);

//computed
const product = computed(() => {
    return getProductWithId(props.id);
});

const category = categoryStore.getCategoryWithId(product.value?.category_id);

const productImages = computed(() => {
    if (product.value?.album) {
        return [product.value?.image, ...product.value?.album];
    } else return [product.value?.image];
});

//hooks
onUpdated(() => {});

//provides
provide("productImages", productImages);
provide(
    "id",
    computed(() => props.id),
);
provide("currentImageIndex", currentImageIndex);
provide("lightbox", lightbox);
provide("product", product);
provide("category", category);
</script>

<style lang="scss" scoped></style>
