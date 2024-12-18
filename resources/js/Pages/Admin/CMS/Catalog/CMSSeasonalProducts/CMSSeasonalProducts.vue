<template>
    <div class="relative col-span-full space-y-3 rounded-lg border p-3 text-xs">
        <CMSHeading>Seasonal</CMSHeading>

        <div class="flex items-center gap-3">
            <div>
                <p>
                    You don’t need to add products to this component, as it
                    dynamically populates based on the current season.
                </p>
            </div>
            <CMSButtonClose
                class="ml-auto"
                @click="handleDeleteNode"
            ></CMSButtonClose>
        </div>

        <CMSSPOptions ref="options" />

        <div class="flex justify-end">
            <CMSButtonSave @click="handleUpdateNode"></CMSButtonSave>
        </div>
    </div>
</template>

<script setup>
import { useCMSUIStore } from "../../../../../stores/ui/CMSUIStore";
import { useProductStore } from "../../../../../stores/productStore";

import CMSButtonClose from "../CMSButton/CMSButtonClose.vue";
import CMSHeading from "../CMSHeading.vue";
import CMSButtonSave from "../CMSButton/CMSButtonSave.vue";
import CMSSPOptions from "./CMSSPOptions.vue";
import { computed, inject, provide, ref } from "vue";

const props = defineProps({
    id: String,
    parentId: String,
    data: Object,
});

const addToast = inject("addToast");
const cmsUiStore = useCMSUIStore();
const productStore = useProductStore();

const seasonalProducts = ref(props.data?.selectedProducts ?? null);

if (!seasonalProducts.value)
    seasonalProducts.value = await productStore.getSeasonalProducts();

provide(
    "selectedProductsCount",
    computed(() => seasonalProducts?.value?.data?.length),
);
provide(
    "data",
    computed(() => props.data ?? seasonalProducts.value),
);
const options = ref(null);

function handleDeleteNode() {
    cmsUiStore.deleteNode(props);
}

function handleUpdateNode() {
    cmsUiStore.updateNode({
        ...props,
        data: {
            ...options.value,
            selectedProducts: seasonalProducts?.value.data ?? seasonalProducts.value,
        },
    });

    addToast({
        props: {
            type: "success",
        },
        content: "Seasonal Product Saved.",
    });
}
</script>

<style lang="scss" scoped></style>
