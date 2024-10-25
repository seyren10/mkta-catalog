<template>
    <div class="mt-3 w-full">
        <div class="grid grid-cols-2">
            <div class="col-span-2 md:col-span-2">
                <p class="text-xl" v-show="showTitle">Product Information</p>
                <div class="grid grid-cols-2">
                    <v-text-field
                        :readonly="
                            readOnlyData?.includes(
                                'productStore.form.parent_code',
                            )
                        "
                        v-model="productItem.parent_code"
                        label="Parent Code"
                    />
                    <v-text-field
                        :readonly="
                            readOnlyData?.includes('productStore.form.id')
                        "
                        v-model="productItem.id"
                        label="Product Item Code"
                    />
                    <v-text-field
                        :readonly="
                            readOnlyData?.includes('productStore.form.title')
                        "
                        v-model="productItem.title"
                        label="Title"
                    />
                    <v-text-field
                        :readonly="
                            readOnlyData?.includes(
                                'productStore.form.description',
                            )
                        "
                        v-model="productItem.description"
                        label="Description"
                    />
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <p class="text-xl">Dimensions</p>
                <div>
                    <v-text-field
                        v-model="product.dimension_length"
                        :readonly="
                            readOnlyData?.includes(
                                'productStore.form.dimension_length',
                            )
                        "
                        label="Length"
                        type="number"
                        step="0.01"
                        min="0"
                        max="9999.99"
                    >
                        <template #append-inner> cm </template>
                    </v-text-field>
                    <v-text-field
                        v-model="product.dimension_width"
                        :readonly="
                            readOnlyData?.includes(
                                'productStore.form.dimension_width',
                            )
                        "
                        label="Width"
                        type="number"
                        step="0.01"
                        min="0"
                        max="9999.99"
                    >
                        <template #append-inner> cm </template>
                    </v-text-field>
                    <v-text-field
                        v-model="product.dimension_height"
                        :readonly="
                            readOnlyData?.includes(
                                'productStore.form.dimension_height',
                            )
                        "
                        label="Height"
                        type="number"
                        step="0.01"
                        min="0"
                        max="9999.99"
                    >
                        <template #append-inner> cm </template>
                    </v-text-field>
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <p class="text-xl">Volume and Weight</p>
                <div>
                    <v-text-field
                        v-model="product.volume"
                        :readonly="
                            readOnlyData?.includes('productStore.form.volume')
                        "
                        label="Volume"
                        type="number"
                        step="0.01"
                        min="0"
                        max="9999.99"
                    >
                        <template #append-inner> m<sup>3</sup> </template>
                    </v-text-field>
                    <v-text-field
                        v-model="product.weight_net"
                        :readonly="
                            readOnlyData?.includes(
                                'productStore.form.weight_net',
                            )
                        "
                        label="Net Weight"
                        type="number"
                        step="0.01"
                        min="0"
                        max="9999.99"
                    >
                        <template #append-inner> kgs </template>
                    </v-text-field>
                    <v-text-field
                        v-model="product.weight_gross"
                        :readonly="
                            readOnlyData?.includes(
                                'productStore.form.weight_gross',
                            )
                        "
                        label="Gross Weight"
                        type="number"
                        step="0.01"
                        min="0"
                        max="9999.99"
                    >
                        <template #append-inner> kgs </template>
                    </v-text-field>
                </div>
            </div>
        </div>
        <div>
            <v-button
            v-show="isValid"
                @click="
                    async () => {
                        await productStore.updateProductItem_2(product.id, product);
                        $emit('productItemUpdate')
                    }
                "
                prepend-inner-icon="md-save-round"
                class="my-2 ml-auto bg-accent text-white"
                >Update Product Item</v-button
            >
        </div>
    </div>
</template>
<script setup>
import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";
const productStore = inject("productStore");

const emits = defineEmits(["update", 'productItemUpdate']);
const props = defineProps({
    productItem: {
        type: Object,
        default: [],
    },
    readOnlyData: { type: Object, default: [] },
    showTitle: { type: Boolean, default: true },
});
const product = ref([]);
product.value = props.productItem;
const isValid = computed(() => {
    if (product.value.id == "" || product.value.title == "") {
        return false;
    }
    return true;
});
</script>
