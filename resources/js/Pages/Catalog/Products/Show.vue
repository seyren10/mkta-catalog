<template>
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

    <LightBox v-model="lightbox" :items="productImages" :key="id"></LightBox>
</template>

<script setup>
import { computed, inject, provide, ref } from "vue";
import { useProductStore } from "../../../stores/productStore";
import { storeToRefs } from "pinia";

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
const { product_item: product } = storeToRefs(productStore);

//injects
const categoryStore = inject("categoryStore");

//reactives
const currentImageIndex = ref(0);
const lightbox = ref(false);
const s3 = inject("s3");

await init();

//computed
const category = categoryStore.getCategoryWithId(
    product.value.product_categories?.at(0)?.id,
);

const productImages = computed(() => {
    return product.value.product_images?.reduce((acc, cur) => {
        acc.push(s3(cur.file.filename));
        return acc;
    }, []);
});

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

//init

async function init() {
    await productStore.getProductItem(props.id);
}
console.log('init again')
</script>

<style lang="scss" scoped></style>
