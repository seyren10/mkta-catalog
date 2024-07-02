<template>
    <div>
        <v-button class="w-full bg-accent uppercase text-white" @click="()=>{categoryStore.resetForm(), showInsert = true, form.parent_id = category.id}"
                >Add Child Category</v-button
            >
        <v-dialog
            persistent
            title="Category"
            @close="categoryStore.resetForm(), (showInsert = false)"
            v-model="showInsert"
        >
            <div class="min-w-[800px] p-5">
                <CategoryNew
                    @close="categoryStore.resetForm(), (showInsert = false), categoryStore.getCategory(id)"
                    
                    :parent_id="category.id"
                    :parent_data="{
                        title: category.title,
                        description: category.description,
                    }"
                />
            </div>
        </v-dialog>
        <CategorySubTree
            @update="categoryStore.getCategory(id)"
            class="my-2"
            v-for="subCategory in category.sub_categories"
            :data="subCategory"
            :parent_id="category.parent_id"
        />
    </div>
</template>
<script setup>
import CategorySubTree from "./CategorySubTree.vue";
import CategoryNew from "../essentials/CategoryNew.vue";

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

const showInsert = ref(false);

</script>

<style lang="scss" scoped></style>
