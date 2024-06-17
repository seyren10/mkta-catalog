<template>
    <v-accordion>
        <template #title>
            <div>
                <h2 class="text-xl font-bold">{{ data.title }}</h2>
                <p class="text-gray-600">
                    {{ data.description }}
                </p>
            </div>
        </template>
        <div>
            <v-button
                class="w-full bg-accent uppercase text-white"
                @click="
                    () => {
                        categoryStore.resetForm(),
                            (showInsert = true),
                            (form.parent_id = data.id);
                    }
                "
                >Add Child Category</v-button
            >
            <CategorySubTree
                @update="
                    () => {
                        $emit('update');
                    }
                "
                class="my-2"
                v-for="subCategory in data.sub_categories"
                :data="subCategory"
                :parent_id="subCategory.parent_id"
            />
        </div>
        <v-dialog
            persistent
            title="Category"
            @close="categoryStore.resetForm(), (showInsert = false)"
            v-model="showInsert"
        >
            <div class="min-w-[800px] p-5">
                <CategoryNew
                    @close="
                        categoryStore.resetForm(),
                            (showInsert = false),
                            $emit('update')
                    "
                    :parent_data="{
                        title: data.title,
                        description: data.description,
                    }"
                />
            </div>
        </v-dialog>
    </v-accordion>
</template>
<script setup>
import CategoryNew from "../essentials/CategoryNew.vue";
import CategorySubTree from "./CategorySubTree.vue";

const emits = defineEmits(["update"]);

import { storeToRefs } from "pinia";
import { onBeforeMount, ref, watch, computed, inject } from "vue";

import { useCategoryStore } from "@/stores/categoryStore";
const categoryStore = useCategoryStore();
const { category, form, loading, errors } = storeToRefs(categoryStore);

const props = defineProps({
    parent_id: {
        type: Number,
        default: 0,
    },
    data: {
        type: Object,
        default: null,
    },
});
const showInsert = ref(false);
</script>
