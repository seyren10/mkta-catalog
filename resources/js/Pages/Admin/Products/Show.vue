<script setup>
import productItemForm from "./components/productItemForm.vue";
import productRestrictionExemption from "./components/productRestrictionExemption.vue";
import productCategories from "./components/productCategories.vue";
import productComponents from "./components/productComponents.vue";
import productImages from "./components/productImages.vue";
import productFilter from "./components/productFilter.vue";
import ProductDeleteForm from "./components/productDeleteForm.vue";

import relatedProduct from "./components/relatedProduct.vue";
import recommendedProduct from "./components/recommendedProduct.vue";
const router = inject("router");

const props = defineProps({
    id: String,
});

import { onBeforeMount, ref, watch, computed, inject, provide } from "vue";
import { storeToRefs } from "pinia";

import { useProductStore } from "@/stores/productStore";

const product_item = ref({
    id : ''
});
const productStore = useProductStore();
const { errors } = storeToRefs(productStore);

provide("productStore", productStore);
provide("product_item", product_item);
provide("router", router);



const refreshProductItem = async () => {
    product_item.value = await productStore.getProductItem(props.id, {
        includeRelatedProducts: true,
        includeRecommendedProduct: true,
        includeVariants: false,
        includeProductImages: false,
        includeProductComponents: false,
    });
    
};
await refreshProductItem();




const currentTab = ref("ProdInfo");
const tabs = ref([
    {
        icon: "bi-cart4",
        iconScale: "1.5",
        title: "Information",
        value: "ProdInfo",
    },
    {
        icon: "md-category",
        iconScale: "1.5",
        title: "Categories",
        value: "Categories",
    },
    {
        icon: "fa-puzzle-piece",
        iconScale: "1.5",
        title: "Components",
        value: "ProductComponents",
    },
    {
        icon: "fa-images",
        iconScale: "1.5",
        title: "Images",
        value: "ProductImages",
    },
    // {
    //     icon: "bi-cart-x",
    //     title: "Non Wishlist Customers",
    //     iconScale: "1.5",
    //     value: "NonWishlistCustomers",
    // },
    {
        icon: "ai-closed-access",
        iconScale: "1.5",
        title: "Restriction & Exemptions",
        value: "ProductAccess",
    },
    {
        icon: "ri-node-tree",
        iconScale: "1.5",
        title: "Related Products",
        value: "RelatedProduct",
    },
    {
        icon: "la-object-group-solid",
        iconScale: "1.5",
        title: "Recommended Products",
        value: "RecommendedProduct",
    },
    {
        icon: "hi-solid-filter",
        iconScale: "1.5",
        title: "Filters",
        value: "ProductFilters",
    },
]);
</script>
<template>
    <div class="pt-2">
        <v-heading type="h2">
            <v-icon
                v-if="$route.meta.redirectTo"
                @click="
                    () => {
                        router.push({ name: $route.meta.redirectTo });
                    }
                "
                name="la-arrow-circle-left-solid"
                scale="1.8"
            ></v-icon
            >{{ $route.meta.title }}</v-heading
        >
        <p>
            {{ $route.meta.description }}
        </p>
    </div>
    <div class="my-3">
        <v-tab
            headerClass=" bg-white"
            no-navigation
            v-model="currentTab"
            :tabs="tabs"
        >
            /*ANCHOR - Product Information */
            <template class="p-3" #content.ProdInfo>
                <div class="p-3">
                    <p>
                        A concise overview of the Product, its Dimensions, and
                        Volume and Weights
                    </p>
                    
                    <productItemForm
                        @productItemUpdate="refreshProductItem"
                        :productItem="product_item"
                        :showTitle="false"
                        :readOnlyData="['form.id']"
                    />
                    <div class="flex justify-center">
                        <ProductDeleteForm :product_id="product_item.id" />
                    </div>
                    
                </div>
            </template>
            /*ANCHOR - Product Categories */
            <template #content.Categories>
                <productCategories @productItemUpdate="refreshProductItem" />
            </template>
            /*ANCHOR - Components */
            <template #content.ProductComponents>
                <productComponents :product_data="product_item" />
            </template>
            /*ANCHOR - Product Images */
            <template #content.ProductImages>
                <productImages :product_id="id" />
            </template>

            /*ANCHOR - Restriction and Exemptions */
            <template #content.ProductAccess>
                <productRestrictionExemption
                    :product_data="product_item"
                    @productItemUpdate="refreshProductItem"
                />
            </template>

            /*ANCHOR - Related Products */
            <template class="p-3" #content.RelatedProduct>
                <relatedProduct :product_data="product_item" />
            </template>
            <template class="p-3" #content.RecommendedProduct>
                <recommendedProduct :product_data="product_item" />
            </template>
            <template class="p-3" #content.ProductFilters>
                <productFilter :product_data="product_item" />
            </template>
        </v-tab>
    </div>
</template>