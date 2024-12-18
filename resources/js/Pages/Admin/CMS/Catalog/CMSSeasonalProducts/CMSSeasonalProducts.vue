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

        <div class="flex justify-end">
            <CMSButtonSave @click="handleUpdateNode"></CMSButtonSave>
        </div>
    </div>
</template>

<script setup>
import { useCMSUIStore } from "../../../../../stores/ui/CMSUIStore";
import CMSButtonSave from "../CMSButton/CMSButtonSave.vue";
import { useProductStore } from "../../../../../stores/productStore";

import CMSButtonClose from "../CMSButton/CMSButtonClose.vue";
import CMSHeading from "../CMSHeading.vue";

const props = defineProps({
    id: String,
    parentId: String,
    data: Object,
});
const cmsUiStore = useCMSUIStore();
const productStore = useProductStore();

function handleDeleteNode() {
    cmsUiStore.deleteNode(props);
}

async function handleUpdateNode() {
    const seasonalProducts = await productStore.getSeasonalProducts();
    console.log(seasonalProducts);
    cmsUiStore.updateNode({
        ...props,
        data: {},
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
