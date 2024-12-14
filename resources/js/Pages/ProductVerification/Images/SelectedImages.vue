<script setup>
import { inject } from "vue";

const props = defineProps({
    selectedImages: Array,
});

const s3Thumbnail = inject("s3Thumbnail");
</script>
<template>
    <div
        v-if="selectedImages?.length"
        class="my-4 grid min-h-[15rem] place-content-center rounded-md border border-dashed text-gray-400"
    >
        <ul class="mx-auto grid w-fit md:grid-cols-3 lg:grid-cols-5">
            <li
                v-for="image in selectedImages"
                :key="image.id"
                class="max-w-[10rem]"
            >
                <img :src="s3Thumbnail(image.filename)" alt="" />
            </li>
        </ul>
    </div>
    <div
        v-else
        class="my-4 grid min-h-[15rem] place-content-center rounded-md border border-dashed text-gray-400"
    >
        <v-icon name="pr-images" scale="3" class="m-auto"></v-icon>
        <p>Select images to start uploading</p>
    </div>
</template>

<style lang="scss" scoped></style>
