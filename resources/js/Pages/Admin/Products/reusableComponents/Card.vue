<template>
    <v-card class="grid h-full grid-cols-1">
        <template #header v-if="showDelete">
            <div class="flex justify-end">
                <v-button
                    class="!rounded-full bg-red-500 !p-1 text-white"
                    @click="emit('close')"
                >
                    <v-icon name="md-close-round"></v-icon>
                </v-button>
            </div>
        </template>
        <div class="flex w-full justify-center">
            <v-text-on-image
                class="h-[150px] max-h-[150px] border-none"
                title="Thumbnail"
                :noOverlay="true"
                :image="s3(data.product_thumbnail?.file?.filename)"
            />
        </div>
        <p class="text-center text-lg text-gray-400">{{ data.id }}</p>
        <div class="">
            <p class="text-center text-xl">{{ data.title }}</p>
            <span class="text-justify indent-2">{{ data.description }}</span>
        </div>
    </v-card>
</template>
<script setup>
import { computed, ref, inject } from "vue";

const emit = defineEmits(["close"]);
const s3 = inject("s3");

const props = defineProps({
    showDelete: {
        type: Boolean,
        default: false,
    },
    data: {
        type: Object,
        default: {},
    },
});
</script>
