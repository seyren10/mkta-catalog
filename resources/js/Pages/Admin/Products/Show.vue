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
    <div class="">
        <productItemForm :showTitle="false" :readOnlyData="['form.id']" />
        
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
<script setup>
import productItemForm from "./components/productItemForm.vue";

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
</script>
