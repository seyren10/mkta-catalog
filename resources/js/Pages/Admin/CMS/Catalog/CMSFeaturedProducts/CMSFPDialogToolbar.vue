<template>
    <div class="flex items-center justify-between rounded-lg bg-slate-100 p-3">
        <div class="flex items-center gap-2">
            <v-text-field
                placeholder="search"
                @keydown.enter="handleSubmit"
                v-model="search"
            >
                <template #append-inner>
                    <v-button
                        icon="pr-times-circle"
                        icon-size=".8"
                        v-if="search"
                        @click="clearSearch"
                    ></v-button>
                </template>
            </v-text-field>
            <v-select
                v-model="selectedCategory"
                :items="categories"
                item-title="title"
                position="bottom"
                @change="handleSubmit"
            ></v-select>
            <v-button
                icon="la-search-solid"
                class="p-3 text-accent"
                icon-size=".9"
                @click="handleSubmit"
            ></v-button>
        </div>
        <slot :data="payload"></slot>
    </div>
</template>

<script setup>
import { useCategoryStore } from "@/stores/categoryStore";
import { storeToRefs } from "pinia";
import { computed, onBeforeMount, ref } from "vue";

const emits = defineEmits(["change"]);
const { categoryList: categories, selectedCategory } = await useCategory();
const search = ref("");

const payload = computed(() => {
    return {
        search: search.value,
        selected: selectedCategory.value,
    };
});

function handleSubmit() {
    emits("change", payload.value);
}
function clearSearch() {
    search.value = "";
    emits("change", payload.value);
}

async function useCategory() {
    const categoryStore = useCategoryStore();
    const { categories } = storeToRefs(categoryStore);
    const selectedCategory = ref(null);

    if (!categories.value.length) {
        await categoryStore.getCategories();
    }

    const categoryList = computed(() => {
        return [{ id: -1, title: "All Categories" }, ...categories.value];
    });

    selectedCategory.value = categoryList.value[0].id;

    return {
        categoryList,
        selectedCategory,
    };
}
</script>

<style lang="scss" scoped></style>
