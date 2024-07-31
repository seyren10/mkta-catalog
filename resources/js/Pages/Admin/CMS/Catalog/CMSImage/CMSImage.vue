<template>
    <div class="relative grow rounded-lg border p-3">
        <span
            class="absolute -top-2 left-[50%] -translate-x-[50%] bg-white text-xs"
        >
            Image</span
        >
        <div class="flex items-start gap-3">
            <v-button
                class="bg-accent text-xs text-white"
                prepend-inner-icon="pr-file"
                icon-size=".8"
                @click="dialog = !dialog"
                >Select Image
            </v-button>

            <div v-if="selectedImage" class="flex items-center gap-3">
                <img
                    :src="s3(selectedImage.filename)"
                    alt=""
                    class="aspect-square max-w-10 rounded-lg object-cover"
                />
                <p>{{ selectedImage.title }}</p>
            </div>
        </div>
        <v-dialog v-model="dialog" persistent max-width="1000">
            <template #header="props">
                <div class="flex items-center justify-between p-3">
                    <h3 class="text-sm font-medium">Select an Image file</h3>
                    <v-button
                        icon="md-close-round"
                        icon-size="1"
                        v-bind="props"
                    ></v-button>
                </div>
            </template>

            <CMSImageFileSelection
                items-per-page="30"
                @submit="handleSubmit"
            ></CMSImageFileSelection>
        </v-dialog>
    </div>
</template>

<script setup>
import { inject, onMounted, ref } from "vue";
import { useCMSStore } from "../../../../../stores/ui/CMSStore";

import CMSImageFileSelection from "./CMSImageFileSelection.vue";

const props = defineProps({
    id: String,
    parentId: String,
    type: String,
});
const dialog = ref(false);
const CMSStore = useCMSStore();
const selectedImage = ref(null);
const s3 = inject("s3");

function handleRemoveNode(node) {
    CMSStore.removeNode({ props: { id: props.id, parentId: props.parentId } });
}

function handleSubmit(items) {
    dialog.value = false;
    selectedImage.value = items.at(0);
}

onMounted(() => {
    console.log("cms image", props.id);
});
</script>

<style lang="scss" scoped></style>
