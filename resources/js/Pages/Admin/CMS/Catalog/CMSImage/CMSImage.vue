<template>
    <div class="relative col-span-full space-y-3 rounded-lg border p-3">
        <CMSHeading>Image</CMSHeading>
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

            <CMSButtonClose
                class="ml-auto"
                @click="handleDeleteNode"
            ></CMSButtonClose>
        </div>

        <template v-if="selectedImage">
            <CMSImageLink
                v-model:path="selectedImage.path"
                v-model:link="selectedImage.link"
            ></CMSImageLink>

            <CMSImageOverlay
                v-model:overlay="selectedImage.overlay"
                v-model:heading="selectedImage.heading"
                v-model:paragraph="selectedImage.paragraph"
            ></CMSImageOverlay>
        </template>

        <div class="flex justify-end">
            <CMSButtonSave @click="handleUpdateNode"></CMSButtonSave>
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
import { inject, ref } from "vue";
import { useCMSUIStore } from "../../../../../stores/ui/CMSUIStore";

import CMSImageFileSelection from "./CMSImageFileSelection.vue";
import CMSHeading from "../CMSHeading.vue";
import CMSButtonClose from "../CMSButton/CMSButtonClose.vue";
import CMSImageLink from "./CMSImageLink.vue";
import CMSButtonSave from "../CMSButton/CMSButtonSave.vue";
import CMSImageOverlay from "./CMSImageOverlay.vue";

const props = defineProps({
    id: String,
    parentId: String,
    data: Object,
});

const dialog = ref(false);
const cmsStore = useCMSUIStore();
const selectedImage = ref(props.data);
const s3 = inject("s3");
const addToast = inject("addToast");

function handleDeleteNode() {
    cmsStore.deleteNode(props);
}

function handleUpdateNode() {
    cmsStore.updateNode({ ...props, data: selectedImage.value });

    addToast({
        props: {
            type: "success",
        },
        content: "Carousel Saved.",
    });
}

function handleSubmit(items) {
    dialog.value = false;
    selectedImage.value = items.at(0);
}
</script>

<style lang="scss" scoped></style>
