<template>
    <div class="mt-3 w-full">
        <div class="grid grid-cols-2">
            <div class="col-span-2 md:col-span-2">
                <p class="text-xl" v-show="showTitle">Product Information</p>
                <div class="grid grid-cols-2">
                    <v-text-field
                        :readonly="readOnlyData?.includes('form.parent_code')"
                        v-model="form.parent_code"
                        label="Parent Code"
                    />
                    <v-text-field
                        :readonly="readOnlyData?.includes('form.id')"
                        v-model="form.id"
                        label="Product Item Code"
                    />
                    <v-text-field
                        :readonly="readOnlyData?.includes('form.title')"
                        v-model="form.title"
                        label="Title"
                    />
                    <v-text-field
                        :readonly="readOnlyData?.includes('form.description')"
                        v-model="form.description"
                        label="Description"
                    />
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <p class="text-xl">Dimensions</p>
                <div>
                    <v-text-field
                        v-model="form.dimension_length"
                        :readonly="readOnlyData?.includes('form.dimension_length')"
                        label="Length"
                        type="number"
                        step="0.01"
                        min="0"
                        max="9999.99"
                    >
                        <template #append-inner> cm </template>
                    </v-text-field>
                    <v-text-field
                        v-model="form.dimension_width"
                        :readonly="readOnlyData?.includes('form.dimension_width')"
                        label="Width"
                        type="number"
                        step="0.01"
                        min="0"
                        max="9999.99"
                    >
                        <template #append-inner> cm </template>
                    </v-text-field>
                    <v-text-field
                        v-model="form.dimension_height"
                        :readonly="readOnlyData?.includes('form.dimension_height')"
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
                        v-model="form.volume"
                        :readonly="readOnlyData?.includes('form.volume')"
                        label="Volume"
                        type="number"
                        step="0.01"
                        min="0"
                        max="9999.99"
                    >
                        <template #append-inner> m<sup>3</sup> </template>
                    </v-text-field>
                    <v-text-field
                        v-model="form.weight_net"
                        :readonly="readOnlyData?.includes('form.weight_net')"
                        label="Net Weight"
                        type="number"
                        step="0.01"
                        min="0"
                        max="9999.99"
                    >
                        <template #append-inner> kgs </template>
                    </v-text-field>
                    <v-text-field
                        v-model="form.weight_gross"
                        :readonly="readOnlyData?.includes('form.weight_gross')"
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
    </div>
</template>
<script setup>
import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";

import { useProductStore } from "@/stores/productStore";
const productStore = useProductStore();
const { form } = storeToRefs(productStore);

const emits = defineEmits(["update"]);

const props = defineProps({
    readOnlyData: { type: Object, default: [] },
    showTitle: { type: Boolean, default: true },
});
</script>
