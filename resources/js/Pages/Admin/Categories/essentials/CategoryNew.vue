<template>
    <div class="cols-3 px-2 md:col-span-2">
        <div v-if="parent_data != null" class="mb-4 border-b-2">
            <h2 class="text-xl font-bold mb-2">Parent Category Information</h2>
            <h2 class="text-lg font-bold">{{ parent_data.title }}</h2>
            <p class="text-gray-600">
                {{ parent_data.description }}
            </p>
        </div>
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
                @click="()=>{ categoryStore.addCategory(id), $emit('close')}"
                prepend-inner-icon="md-save-round"
                class="ml-auto bg-accent text-white"
                >Save Category Information</v-button
            >
        </div>
    </div>
</template>
<script setup>
import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";
const emits = defineEmits(["close"]);

const props = defineProps({
    parent_data: {
        type: Object,
        default: null,
    },
});

import { useCategoryStore } from "@/stores/categoryStore";
const categoryStore = useCategoryStore();
const { form, loading, errors } = storeToRefs(categoryStore);
</script>
