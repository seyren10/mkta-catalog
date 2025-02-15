<script setup>
import CMSImageFileSelection from "@/Pages/Admin/CMS/Catalog/CMSImage/CMSImageFileSelection.vue";
import SelectedImages from "./SelectedImages.vue";
import { inject, markRaw, onMounted, ref } from "vue";
import { useProductVerificationStore } from "../../../stores/productVerificationStore";
import { storeToRefs } from "pinia";

const productVerificationStore = useProductVerificationStore();
const { item } = storeToRefs(productVerificationStore);
const imageUploadDialog = ref(false);
const selectedImages = ref([]);
const form = inject("verifyForm");
const addToast = inject("addToast");

async function handleUpdloadBanner(images) {
    selectedImages.value = images;
    form.value["images"] = selectedImages.value;
    await productVerificationStore.temporarySaveImages(
        item.value.product_id,
        images,
    );
    imageUploadDialog.value = false;

    addToast({
        props: {
            type: "info",
        },
        content: "Your work has been automatically saved.",
    });
}

async function getTempImages() {
    const images = await productVerificationStore.getTemporaryImages(
        item.value.product_id,
    );

    if (images) {
        const parsedImages = JSON.parse(images.data);
        selectedImages.value = parsedImages;
        form.value["images"] = parsedImages;
    }
}

/* INIT */

await getTempImages();
</script>
<template>
    <div>
        <div class="flex gap-2">
            <v-button
                @click="imageUploadDialog = true"
                class="border bg-none text-primary"
                >Select Images</v-button
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
