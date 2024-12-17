<script setup>
const emit = defineEmits(["upload"]);

function handleUpload(event) {
    emit("upload", event);
}
</script>

<template>
    <v-dialog persistent>
        <template #header="props">
            <div class="flex items-center justify-between p-3">
                <h3 class="text-sm font-medium">Upload images</h3>
                <v-button
                    icon="md-close-round"
                    icon-size="1"
                    v-bind="props"
                ></v-button>
            </div>
        </template>

        <div class="p-3 text-sm">
            <input
                type="file"
                id="imageUpload"
                class="hidden"
                accept=".jpeg, .jpg, .png, .gif, .webp"
                multiple
                @change="handleUpload"
            />
            <label
                for="imageUpload"
                class="block aspect-video w-[20rem] cursor-pointer mx-auto"
            >
                <div
                    class="grid h-full place-content-center rounded-md border border-dashed text-gray-400"
                >
                    <v-icon name="pr-images" scale="3" class="mx-auto"></v-icon>

                    <p class="text-center text-xs">
                        Click here to start uploading
                    </p>
                </div>
            </label>
            <slot />
        </div>
    </v-dialog>
</template>

<style lang="scss" scoped></style>
