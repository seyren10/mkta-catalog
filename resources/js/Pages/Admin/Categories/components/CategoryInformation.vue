<template>
    <!-- <v-card class="border-0"> -->
    <div class="grid grid-cols-3 gap-0">
        <div class="cols-3 md:col-span-1">
            <v-text-on-image
                class="bg-gray-400 p-2"
                title="Thumbnail"
                subtitle="subtitle"
                align="center"
                :noOverlay="true"
                :appear="false"
                :image="'/' + [category.img].join('/')"
            />
        </div>
        <div class="cols-3 px-2 md:col-span-2">
            <v-text-field
                prepend-inner-icon="px-subtitles"
                label="Title"
                v-model="form.title"
            />
            <v-text-field
                prepend-inner-icon="bi-text-paragraph"
                label="Description"
                v-model="form.description"
            />
            <div class="col-span-12 md:col-span-6">
                <v-button
                    @click="categoryStore.updateCategory(id)"
                    prepend-inner-icon="md-save-round"
                    class="ml-auto bg-accent text-white"
                    >Update Category</v-button
                >
            </div>
        </div>
    </div>
    <!-- </v-card> -->
</template>
<script setup>
import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";

const router = inject("router");
const props = defineProps({
    id: String,
});

import { useCategoryStore } from "@/stores/categoryStore";
const categoryStore = useCategoryStore();
const { category, form, loading, errors } = storeToRefs(categoryStore);
if (!category.length) {
    await categoryStore.getCategory(props.id);
}
</script>

<style lang="scss" scoped></style>
