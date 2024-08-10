<template>
    <div class="grid grid-cols-1 gap-2 py-2">
        <h2 class="mb-4 text-gray-800">
            This section displays the related / variants of the selected
            product.
        </h2>
        <div class="flex content-end justify-end gap-2">
            <v-button
                @click="insertRelatedProduct = true"
                class="bg-accent text-white"
                ><v-icon name="bi-plus" class="me-2" scale="1.2"></v-icon>Append
                Related Product</v-button
            >
            <v-button @click="refreshRelatedProducts" class="border">
                <v-icon
                    class="me-2"
                    scale="1.2"
                    name="md-refresh-sharp"
                ></v-icon>
                Refresh Related Products</v-button
            >
        </div>
        <div class="grid grid-cols-5 gap-2 mt-2">
            <template v-for="item in related_products">
                <ProductCard @close="removeRelatedProduct(item.id)" :data="item.product" :showDelete="true" />
            </template>
        </div>
        <v-dialog
            persistent
            title="Related Products"
            v-model="insertRelatedProduct"
            @close="closeRelatedProducts()"
        >
            <div class="min-w-[800px] p-5">
                <ProductList
                    @close="closeRelatedProducts()"
                    @cancel="closeRelatedProducts()"
                    @submitSelection="appendRelatedProducts"
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


const emit = defineEmits(["update"]);

const s3 = inject("s3");
const productStore = inject("productStore");
const product_item = inject("product_item");

//SECTION - Link Store
import { useLinkProductStore } from "@/stores/linkProductStore";
const linkProductStore = useLinkProductStore();
const { related_products } = storeToRefs(linkProductStore);
const refreshRelatedProducts = async () => {
    await linkProductStore.getRelatedProducts(product_item.value.id);
};

if(product_item.value.related_product.length > 0){
    related_products.value = product_item.value.related_product;
}else{
    refreshRelatedProducts();
}

//SECTION - Product Store
const appendRelatedProducts_BothWays = ref(false);
const insertRelatedProduct = ref(false);
const closeRelatedProducts = () => {
    insertRelatedProduct.value = false;
};
const removeRelatedProduct = async (id) => {
    await linkProductStore.removeRelatedProduct(id);
    refreshRelatedProducts();
};
const appendRelatedProducts = async (data) => {
    data.forEach(async (element) => {
        await linkProductStore.appendRelatedProduct(product_item.value.id, element.id);
        if (appendRelatedProducts_BothWays) {
            await linkProductStore.appendRelatedProduct(element.id, product_item.value.id);
        }
    });
    closeRelatedProducts();
};
</script>
