<template>
    <template v-if="Object.keys(product).length">
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
import { storeToRefs } from "pinia";

const props = defineProps({
    id: String,
});

//stores
const productStore = useProductStore();
const { product_item: product } = storeToRefs(productStore);

await productStore.getProductItem(props.id);

//injects
const categoryStore = inject("categoryStore");

//reactives
const currentImageIndex = ref(0);
const lightbox = ref(false);
const s3 = inject("s3");

//computed
const category = categoryStore.getCategoryWithId(
    product.value.product_categories?.at(0).id,
);

const productImages = computed(() => {
    return product.value.product_images?.reduce((acc, cur) => {
        acc.push(s3(cur.file.filename));
        return acc;
    }, []);
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
