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
            v-model="currentTab"
            :tabs="[
                {
                    icon: 'bi-cart4',
                    title: 'Information',
                    value: 'ProdInfo',
                },
                {
                    icon: 'md-category',
                    title: 'Categories',
                    value: 'Categories',
                },
                {
                    icon: 'fa-puzzle-piece',
                    title: 'Components',
                    value: 'ProductComponents',
                },
                {
                    icon: 'fa-images',
                    title: 'Images',
                    value: 'ProductImages',
                },
                {
                    icon: 'bi-cart-x',
                    title: 'Non Wishlist Customers',
                    value: 'NonWishlistCustomers',
                },
                {
                    icon: 'ai-closed-access',
                    title: 'Restriction & Exemptions',
                    value: 'ProductAccess',
                },
                
            ]"
        >
            <template #content.Categories>
                <p>
                    This section organizes products into specific Categories,
                    helping customers navigate to find items that match their
                    needs or interests.
                </p>
            </template>
            <template #content.ProductComponents>
                <p>
                    Detailed information is provided about what the product
                    includes or consists of.
                </p>
            </template>
            <template class="p-3" #content.NonWishlistCustomers>
                <productNonWishList :product_id="id" />
            </template>
            <template #content.Restriction>
                <p>
                    This part outlines any limitations or conditions that apply
                    in viewing the Products.
                </p>
            </template>
            <template #content.Exemptions>
                <p>
                    This section clarifies what the access type will be exempted
                    to all kind of restriction.
                </p>
            </template>
            <template class="p-3" #content.ProdInfo>
                <div class="p-3">
                    <p>
                        A concise overview of the Product, its Dimensions, and
                        Volume and Weights
                    </p>
                    <productItemForm
                        :showTitle="false"
                        :readOnlyData="['form.id']"
                    />
                    <div>
                        <v-button
                            v-show="isValid"
                            @click="
                                async () => {
                                    await productStore.updateProductItem(id);
                                    productStore.resetForm();
                                    productStore.getProductItem(id);
                                    showInsert = false;
                                }
                            "
                            prepend-inner-icon="md-save-round"
                            class="ml-auto bg-accent text-white"
                            >Update Product Item</v-button
                        >
                    </div>
                </div>
            </template>
        </v-tab>
    </div>
</template>
<script setup>
import productItemForm from "./components/productItemForm.vue";

import productNonWishList from "./components/productNonWishList.vue";

const router = inject("router");
const props = defineProps({
    id: String,
});

import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";

import { useProductStore } from "@/stores/productStore";
const productStore = useProductStore();
const { product_item, isValid } = storeToRefs(productStore);

if (!product_item.length) {
    await productStore.getProductItem(props.id);
}

const currentTab = ref("NonWishlistCustomers");
</script>
