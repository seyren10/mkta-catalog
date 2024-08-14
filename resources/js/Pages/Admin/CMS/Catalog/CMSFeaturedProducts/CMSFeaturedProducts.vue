<template>
    <div class="relative col-span-full space-y-3 rounded-lg border p-3 text-xs">
        <CMSHeading>Featured</CMSHeading>

        <div class="flex items-center gap-3">
            <v-button
                class="bg-accent text-xs text-white"
                prepend-inner-icon="pr-file"
                icon-size=".8"
                @click="dialog = !dialog"
                >Select Products
            </v-button>
            <div class="text-slate-500">
                <strong>{{ selectedProductsCount }}</strong> product(s)
                selected.
            </div>

            <CMSButtonClose
                class="ml-auto"
                @click="handleDeleteNode"
            ></CMSButtonClose>
        </div>
        <CMSFPOptions ref="options"></CMSFPOptions>

        <div class="flex justify-end">
            <CMSButtonSave @click="handleUpdateNode"></CMSButtonSave>
        </div>
        <v-dialog
            v-model="dialog"
            persistent
            max-width="1000"
            class="min-h-[30rem]"
        >
            <template #header="props">
                <div class="flex items-center justify-between p-3">
                    <h3 class="text-sm font-medium">Select Products</h3>
                    <v-button
                        icon="md-close-round"
                        icon-size="1"
                        v-bind="props"
                    ></v-button>
                </div>
            </template>

            <CMSFPDialog
                class="text-xs"
                v-model="selectedProducts"
                @save="dialog = false"
            ></CMSFPDialog>
        </v-dialog>
    </div>
</template>

<script setup>
import { computed, inject, provide, ref } from "vue";
import { useCMSUIStore } from "../../../../../stores/ui/CMSUIStore";

import CMSButtonClose from "../CMSButton/CMSButtonClose.vue";
import CMSHeading from "../CMSHeading.vue";
import CMSFPDialog from "./CMSFPDialog.vue";
import CMSFPOptions from "./CMSFPOptions.vue";
import CMSButtonSave from "../CMSButton/CMSButtonSave.vue";

const props = defineProps({
    id: String,
    parentId: String,
    data: Object,
});
const selectedProducts = ref(props.data?.selectedProducts ?? []);
const cmsUiStore = useCMSUIStore();
const dialog = ref(false);
const options = ref(null);
const addToast = inject("addToast");

function handleDeleteNode() {
    cmsUiStore.deleteNode(props);
}

function handleUpdateNode() {
    cmsUiStore.updateNode({
        ...props,
        data: { ...options.value, selectedProducts: selectedProducts.value },
    });

    addToast({
        props: {
            type: "success",
        },
        content: "Featured Product Saved.",
    });
}

const selectedProductsCount = computed(() => selectedProducts.value.length);
provide("selectedProductsCount", selectedProductsCount);
provide(
    "data",
    computed(() => props.data),
);
</script>

<style lang="scss" scoped></style>
