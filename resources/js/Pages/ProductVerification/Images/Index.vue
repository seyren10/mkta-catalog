<script setup>
import CMSImageFileSelection from "@/Pages/Admin/CMS/Catalog/CMSImage/CMSImageFileSelection.vue";
import SelectedImages from "./SelectedImages.vue";
import { ref } from "vue";

const imageUploadDialog = ref(false);
const selectedImages = ref([]);

function handleUpdloadBanner(images) {
    selectedImages.value = images;
    imageUploadDialog.value = false;
}
</script>
<template>
    <div>
        <div class="flex gap-2">
            <v-button
                @click="imageUploadDialog = true"
                class="border bg-none text-primary"
                >Select Images</v-button
            >
            <v-button class="bg-accent text-white" v-if="selectedImages.length"
                >Upload</v-button
            >
        </div>

        <SelectedImages :selected-images="selectedImages"></SelectedImages>

        <v-dialog v-model="imageUploadDialog" persistent max-width="1000">
            <template #header="props">
                <div class="flex items-center justify-between p-3">
                    <h3 class="text-sm font-medium">Upload Images</h3>
                    <v-button
                        icon="md-close-round"
                        icon-size="1"
                        v-bind="props"
                    ></v-button>
                </div>
            </template>

            <CMSImageFileSelection
                items-per-page="30"
                :items="selectedImages"
                @submit="handleUpdloadBanner"
                multiple
            ></CMSImageFileSelection>
        </v-dialog>
    </div>
</template>

<style lang="scss" scoped></style>
