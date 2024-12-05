<template>
    <div class="mt-3 space-y-5">
        <div class="flex gap-2 rounded-lg bg-slate-100 p-3 text-[.8rem]">
            <v-icon
                name="pr-exclamation-circle"
                scale="1.2"
                class="fill-slate-400"
            ></v-icon>
            <p class="text-xs text-slate-400">
                <span class="flex items-center font-medium text-primary">
                    Important Note:</span
                >
                <span>
                    By downloading the zip file containing images from our
                    website, you agree not to distribute these images or claim
                    them as your own. Unauthorized use, reproduction, or
                    distribution is prohibited and may result in legal action.
                    Thank you for respecting our terms and supporting our work.
                </span>
            </p>
        </div>
        <v-button
            @click="download"
            prepend-inner-icon="oi-file-zip"
            class="bg-accent text-white"
            >Download ZIP file</v-button
        >
    </div>
</template>
<script setup>
import { inject, ref, computed } from "vue";
import { useProductStore } from "@/stores/productStore.js";
const productStore = useProductStore();
const product = inject("product");
const addToast = inject("addToast");

const { download } = useDownload();

function useDownload() {
    async function download() {
        await productStore.zipProductImages(product.value.id);

        addToast({
            props: {
                type: "info",
                closable: true,
            },
            content: `Your request is being processed. Please check on your profile > notification to check if your download request is finished.`,
        });
    }

    return {
        download,
    };
}
</script>
