<template>
    <div class="relative col-span-full space-y-3 rounded-lg border p-3">
        <CMSHeading>Featured</CMSHeading>

        <div class="flex items-start gap-3">
            <v-button
                class="bg-accent text-xs text-white"
                prepend-inner-icon="pr-file"
                icon-size=".8"
                @click="dialog = !dialog"
                >Select Products
            </v-button>

            <CMSButtonClose
                class="ml-auto"
                @click="handleDeleteNode"
            ></CMSButtonClose>
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

            <CMSFPDialog class="text-xs"></CMSFPDialog>
        </v-dialog>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useCMSUIStore } from "../../../../../stores/ui/CMSUIStore";

import CMSButtonClose from "../CMSButton/CMSButtonClose.vue";
import CMSHeading from "../CMSHeading.vue";
import CMSFPDialog from "./CMSFPDialog.vue";

const props = defineProps({
    id: String,
    parentId: String,
    data: Object,
});

const cmsUiStore = useCMSUIStore();
const dialog = ref(false);

function handleDeleteNode() {
    cmsUiStore.deleteNode(props);
}
</script>

<style lang="scss" scoped></style>
