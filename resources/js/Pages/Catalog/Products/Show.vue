<template>
    <ProductView>
        <template #header>
            <ImageView />
            <ProductInfo />
        </template>
        <template #aside> <RecentViewed></RecentViewed> </template>
        <template #component>
            <TechInfo />
            <ProductComponents v-if="product.product_components.length > 0" />
            <RelatedProducts v-if="product.related_product.length > 0" />
            <RecommendedProducts
                v-if="product.recommended_product.length > 0"
            />
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
import ProductComponents from "./components/ProductComponents.vue";

import RelatedProducts from "./components/RelatedProducts.vue";
import RecommendedProducts from "./components/RecommendedProducts.vue";

import TechInfo from "./components/ProductInfo/TechInfo.vue";

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
// const category = categoryStore.getCategoryWithId(
//     product.value.product_categories?.at(0)?.id,
// );

const category = product.value.product_categories;

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
    await productStore.getProductItem(props.id, {
        // includeProductCategories: false,
        includeRelatedProducts: true,
        includeRecommendedProduct: true,
    });
}

const addItem_in_LocalStorage = () => {
    let recentItems = localStorage.getItem("recent");
    if (recentItems !== null) {
        recentItems = JSON.parse(recentItems);
    } else {
        recentItems = [];
    }
    let exists = recentItems.some((obj) => obj.id === product.value.id);
    if (!exists) {
        let tempData = {
            id: product.value.id,
            title: product.value.title,
            description: product.value.description,
            thumbnail: product.value.product_thumbnail?.file.filename,
        };
        recentItems.push(tempData);
        recentItems = recentItems.slice(0, 10).reverse();
    }
    localStorage.setItem("recent", JSON.stringify(recentItems));
};
addItem_in_LocalStorage();
</script>

<style lang="scss" scoped></style>
