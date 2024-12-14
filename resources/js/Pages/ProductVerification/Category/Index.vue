<script setup>
import { useCategoryStore } from "@/stores/categoryStore";
import { storeToRefs } from "pinia";
import { computed, ref } from "vue";

const categoryStore = useCategoryStore();
const { categories, fetch, selectedCategories, handleCategorySelection } =
    useCategory();
if (!categories.value.length) await fetch();

const form = computed(() => {
    return Object.keys(selectedCategories.value).filter(
        (e) => selectedCategories.value[e] === true,
    );
});

function useCategory() {
    const { categories } = storeToRefs(categoryStore);
    const selectedCategories = ref({});

    async function fetch() {
        await categoryStore.getCategories({
            includeCoverHTML: false,
            includeSubCategories: true,
            includeFile: false,
            includeParentCategory: true,
        });
    }

    function handleCategorySelection(category) {
        /* determine if the category is already selected */
        if (selectedCategories.value[category.id] === true) {
            /* select the parent when child has a parent_category */
            if (category.parent_category) {
                selectedCategories.value[category.parent_category.id] = true;
            }
        } else {
            /* deselect all of the parent's children when parent is deselected */
            const children = category.sub_categories;
            children.forEach((child) => {
                if (selectedCategories.value[child.id] !== "undefined") {
                    selectedCategories.value[child.id] = false;
                }
            });
        }
    }

    return {
        categories,
        fetch,
        selectedCategories,
        handleCategorySelection,
    };
}
</script>
<template>
    <ul class="space-y-2">
        <li v-for="category in categories" :key="category.id">
            <v-checkbox
                :id="category.title"
                v-model="selectedCategories[category.id]"
                :label="category.title"
                @change="handleCategorySelection(category)"
            />

            <ul class="ml-4 mt-2 space-y-2">
                <li v-for="sub in category.sub_categories" :key="sub.id">
                    <v-checkbox
                        :id="sub.title"
                        :label="sub.title"
                        v-model="selectedCategories[sub.id]"
                        @change="handleCategorySelection(sub)"
                    />
                </li>
            </ul>
        </li>
    </ul>
</template>

<style lang="scss" scoped></style>

<!-- 
/* deselect the parent when all of its children is deselected */
if (category.parent_category) {
    const parent = categories.value.find(
        (e) => e.id === category.parent_category.id,
    );
    const noSelectedChild = parent.sub_categories.every((child) => {
        return !selectedCategories.value[child.id];
    });

    if (noSelectedChild) {
        selectedCategories.value[category.parent_category.id] =
            false;
    }
} else { -->
