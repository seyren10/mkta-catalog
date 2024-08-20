<template>
    <div>
        <div class="w-full">
            <v-button @click="refresh" class="ml-auto border"
                ><v-icon name="md-refresh-sharp" class="me-2"></v-icon
                >Refresh</v-button
            >
        </div>

        <template v-for="category in categories">
            <DataCategory :data="category" />
        </template>
    </div>
</template>
<script setup>
import DataCategory from "./components/DataCategory.vue";

import { onBeforeMount, ref, watch, computed, inject, provide } from "vue";


const categories =  ref([])

import { useCategoryStore } from "@/stores/categoryStore";
const categoryStore = useCategoryStore();

provide('categoryStore',categoryStore)

const refresh = async () => {
    const res = await categoryStore.getCategories({includeProducts:true});
    categories.value = res;
};
refresh();

</script>
