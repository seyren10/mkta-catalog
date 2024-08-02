<template>
    <div class="relative basis-full space-y-3 rounded-lg border p-3">
        <CMSHeading>Image Carousel</CMSHeading>
        <div class="flex items-start gap-3">
            <v-button
                class="bg-accent text-xs text-white"
                prepend-inner-icon="pr-file"
                icon-size=".8"
                @click="fileSelector = !fileSelector"
                >Select Images
            </v-button>

            <CMSCarouselImage
                :items="selectedFiles"
                @select="handleImageSelection"
            ></CMSCarouselImage>

            <CMSButtonClose
                class="ml-auto"
                @click="handleDeleteNode"
            ></CMSButtonClose>
        </div>
        <div v-if="selectedFile">
            <div class="mt-4 space-y-4">
                <ul class="text-xs">
                    <li>
                        <span class="text-slate-500">title: </span>
                        <span class="font-medium">{{
                            selectedFile?.title
                        }}</span>
                    </li>
                    <li>
                        <span class="text-slate-500">filename: </span>
                        <span class="font-medium">{{
                            selectedFile?.filename
                        }}</span>
                    </li>
                </ul>
            </div>
            <CMSImageLink
                v-model:link="selectedFile.link"
                v-model:path="selectedFile.path"
            ></CMSImageLink>
        </div>
        <div class="flex justify-end">
            <CMSButtonSave @click="handleUpdateNode"></CMSButtonSave>
        </div>

        <v-dialog v-model="fileSelector" persistent max-width="1000">
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
                :items="selectedFiles"
                items-per-page="30"
                @submit="handleFileSelection"
                multiple
            ></CMSImageFileSelection>
        </v-dialog>
    </div>
</template>

<script setup>
import { inject, ref } from "vue";
import { useCMSStore } from "../../../../../stores/ui/CMSStore";

import CMSImageFileSelection from "../CMSImage/CMSImageFileSelection.vue";
import CMSHeading from "../CMSHeading.vue";
import CMSButtonClose from "../CMSButton/CMSButtonClose.vue";
import CMSCarouselImage from "./CMSCarouselImage.vue";
import CMSButtonSave from "../CMSButton/CMSButtonSave.vue";
import CMSImageLink from "../CMSImage/CMSImageLink.vue";

const props = defineProps({
    id: String,
    parentId: String,
    type: String,
});
const { handleFileSelection, selectedFiles, fileSelector } = useFileSelection();
const cmsStore = useCMSStore();
const addToast = inject("addToast");
const selectedFile = ref(null);

function handleDeleteNode() {
    cmsStore.deleteNode(props);
}

function handleImageSelection(item) {
    selectedFile.value = item;
}

function handleUpdateNode() {
    cmsStore.updateNode({ ...props, cmsData: selectedFiles });

    addToast({
        props: {
            type: "success",
        },
        content: "Carousel Saved.",
    });
}
function useFileSelection() {
    const selectedFiles = ref([]);
    const fileSelector = ref(false);

    function handleFileSelection(files) {
        selectedFiles.value = files;
        fileSelector.value = false;
    }

    return {
        handleFileSelection,
        selectedFiles,
        fileSelector,
    };
}
</script>

<style lang="scss" scoped></style>
