<template>
    <div class="grid grid-cols-1 gap-2 py-2">
        <h2 class="mb-4 text-gray-800">
            This section displays the Recommended / variants of the selected
            product.
        </h2>
        <div class="flex content-end justify-end gap-2">
            <v-button
                @click="insertRecommendedProduct = true"
                class="bg-accent text-white"
                ><v-icon name="bi-plus" class="me-2" scale="1.2"></v-icon>Append
                Recommended Product</v-button
            >
            <v-button @click="refreshRecommendedProducts" class="border">
                <v-icon
                    class="me-2"
                    scale="1.2"
                    name="md-refresh-sharp"
                ></v-icon>
                Refresh Recommended Products</v-button
            >
        </div>
        <div class="grid grid-cols-5 gap-2 mt-2">
            <template v-for="item in Recommended_products">
                <ProductCard @close="removeRecommendedProduct(item.id)" :data="item.product" :showDelete="true" />
            </template>
        </div>
        <v-dialog
            persistent
            title="Recommended Products"
            v-model="insertRecommendedProduct"
            @close="closeRecommendedProducts()"
        >
            <div class="min-w-[800px] p-5">
                <ProductList
                    @close="closeRecommendedProducts()"
                    @cancel="closeRecommendedProducts()"
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


const emit = defineEmits(["productItemUpdate"]);

const props = defineProps({
    product_data: {}
})
const product_item = ref();
product_item.value = props.product_data;



//SECTION - Link Store
import { useLinkProductStore } from "@/stores/linkProductStore";
const linkProductStore = useLinkProductStore();

const { } = storeToRefs(linkProductStore);

const Recommended_products = ref([]);

const refreshRecommendedProducts =  async() => {
    Recommended_products.value = await linkProductStore.getRecommendedProducts_2(product_item.value.id);
};

refreshRecommendedProducts();
//SECTION - Product Store
const appendRecommendedProducts_BothWays = ref(false);
const insertRecommendedProduct = ref(false);
const closeRecommendedProducts = () => {
    insertRecommendedProduct.value = false;
};
const removeRecommendedProduct = async (id) => {
    await linkProductStore.removeRecommendedProduct(id);
    await refreshRecommendedProducts();
};
const appendRecommendedProducts = async (data) => {
    data.forEach(async (element) => {
        await linkProductStore.appendRecommendedProduct(product_item.value.id, element.id);
        if (appendRecommendedProducts_BothWays) {
            await linkProductStore.appendRecommendedProduct(element.id, product_item.value.id);
        }
    });
    closeRecommendedProducts();
};
</script>
