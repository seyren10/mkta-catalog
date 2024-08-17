<template>
    <div class="grid grid-cols-1 gap-2 py-2">
        <h2 class="mb-4 text-gray-800">
            This section displays the recommended / variants of the selected
            product.
        </h2>
        <div class="flex content-end justify-end gap-2">
            <v-button
                @click="insertrecommendedProduct = true"
                class="bg-accent text-white"
                ><v-icon name="bi-plus" class="me-2" scale="1.2"></v-icon>Append
                Recommended Product</v-button
            >
            <v-button @click="refreshrecommendedProducts" class="border">
                <v-icon
                    class="me-2"
                    scale="1.2"
                    name="md-refresh-sharp"
                ></v-icon>
                Refresh Recommended Products</v-button
            >
        </div>
        <div class="grid grid-cols-5 gap-2 mt-2">
            <template v-for="item in recommended_products">
                <ProductCard @close="removeRecommededProduct(item.id)" :data="item.product" :showDelete="true" />
            </template>
        </div>
        <v-dialog
            persistent
            title="recommended Products"
            v-model="insertrecommendedProduct"
            @close="closerecommendedProducts()"
        >
            <div class="min-w-[800px] p-5">
                <ProductList
                    @close="closerecommendedProducts()"
                    @cancel="closerecommendedProducts()"
                    @submitSelection="appendRecommendedProducts"
                />
            </div>
        </v-dialog>
    </div>
</template>
<script setup>
import ProductCard from "../reusableComponents/Card.vue";
import ProductList from "../reusableComponents/Index.vue";

import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";

const s3 = inject("s3");

const product_item = inject("product_item");
const productStore = inject("productStore");

const emit = defineEmits(["update"]);

//SECTION - Link Store
import { useLinkProductStore } from "@/stores/linkProductStore";
const linkProductStore = useLinkProductStore();
const { recommended_products } = storeToRefs(linkProductStore);
const refreshrecommendedProducts = async () => {
    await linkProductStore.getRecommendedProducts(product_item.value.id);
};
if(product_item.value.recommended_product.length > 0){
    recommended_products.value = product_item.value.recommended_product	;
}else{
    refreshrecommendedProducts();
}

//SECTION - Product Store
const appendRecommendedProducts_BothWays = ref(false);
const insertrecommendedProduct = ref(false);
const closerecommendedProducts = () => {
    insertrecommendedProduct.value = false;
};
const removeRecommededProduct = async (id) => {
    await linkProductStore.removeRecommededProduct(id);
    refreshrecommendedProducts();
};
const appendRecommendedProducts = async (data) => {
    data.forEach(async (element) => {
        await linkProductStore.appendRecommendedProduct(product_item.value.id, element.id);
        if (appendRecommendedProducts_BothWays) {
            await linkProductStore.appendRecommendedProduct(element.id, product_item.value.id);
        }
    });
    closerecommendedProducts();
};
</script>
