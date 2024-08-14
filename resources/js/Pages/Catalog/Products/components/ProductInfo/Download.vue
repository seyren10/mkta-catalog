<template>
    <div class="mt-3 space-y-5">
        <div class="flex gap-2 rounded-lg bg-slate-100 p-3 text-[.8rem]">
            <v-icon
                name="pr-exclamation-circle"
                scale="1.2"
                class="fill-slate-400"
            ></v-icon>
            <p class="text-slate-400">
                <span class="flex items-center font-medium text-primary">
                    Important Note:</span
                >
                By downloading the zip file containing images from our website,
                you agree not to distribute these images or claim them as your
                own. Unauthorized use, reproduction, or distribution is
                prohibited and may result in legal action. Thank you for
                respecting our terms and supporting our work.
            </p>
        </div>
        <v-button
            @click="
                () => {
                    showDownloadToast = true;
                    productStore.zipProductImages(product.id);
                }
            "
            prepend-inner-icon="oi-file-zip"
            class="bg-accent text-white"
            >Download ZIP file</v-button
        >
    </div>
</template>
<script setup>
import { inject, ref, computed } from "vue";
import { useProductStore } from "@/stores/productStore.js";
import { storeToRefs } from "pinia";
const productStore = useProductStore();
const product = inject('product')
const showDownloadToast = ref(false);
</script>
