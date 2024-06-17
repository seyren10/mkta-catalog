<template>
    <div class="pt-2">
        <div>
            <v-heading type="h2">
                <v-icon
                    v-if="$route.meta.redirectTo"
                    @click="
                        () => {
                            router.push({ name: $route.meta.redirectTo });
                        }
                    "
                    name="la-arrow-circle-left-solid"
                    scale="1.8"
                ></v-icon
                >{{ $route.meta.title }}</v-heading
            >
            <p>
                {{ $route.meta.description }}
            </p>
        </div>
        <div class="ml-auto w-fit">
            <v-button
                outlined
                prepend-inner-icon="md-category"
                class="float-end block rounded-lg bg-accent p-2 text-white"
                @click="(showInsert = true), categoryStore.resetForm()"
                >New Category</v-button
            >
        </div>
        <div class="py-2">
            <v-text-field
                prepend-inner-icon="la-search-solid"
                v-model="search"
                clearable
            >
            </v-text-field>
            <v-data-table
                class="my-2"
                :headers="[
                    {
                        value: 'id',
                        key: 'id',
                        hidden: true,
                        sortable: false,
                    },
                    {
                        value: 'Details',
                        key: 'title',
                        hidden: false,
                        sortable: true,
                    },
                    {
                        value: 'Description',
                        key: 'description',
                        hidden: true,
                        sortable: true,
                    },
                    {
                        value: '',
                        key: 'action',
                        hidden: false,
                        sortable: false,
                    },
                ]"
                :items="categories"
                :search="search"
                striped
                border
            >
                <template #item.title="{ item }">
                    <h2 class="text-xl font-bold">{{ item.value }}</h2>
                    <p class="text-gray-600">
                        {{ item.raw.description }}
                    </p>
                </template>
                <template #item.action="{ item }">
                    <div class="max-w-40">
                        <v-button
                            class="w-full bg-red-600 text-white"
                            @click="
                                () => {
                                    categoryStore.deleteCategory(item.raw.id),
                                        categoryStore.getCategories();
                                }
                            "
                            outlined
                            prepend-inner-icon="fa-trash-alt"
                        >
                            Delete
                        </v-button>
                        <v-button
                            class="w-full bg-accent text-white"
                            @click="
                                () => {
                                    router.push({
                                        name: 'categoryShow',
                                        params: { id: item.raw.id },
                                    });
                                }
                            "
                            outlined
                            prepend-inner-icon="fa-folder-open"
                        >
                            View
                        </v-button>
                    </div>
                </template>
            </v-data-table>
        </div>
        <v-dialog
            persistent
            title="Category"
            @close="categoryStore.resetForm(), showInsert = false"
            v-model="showInsert"
        >
            <div class="min-w-[800px] p-5">
                <CategoryNew @close="categoryStore.resetForm(), (showInsert = false), categoryStore.getCategories()" :parent_id="0" />
            </div>
        </v-dialog>
    </div>
</template>
<script setup>
import CategoryNew from "./essentials/CategoryNew.vue";


import { onBeforeMount, inject, ref, watch } from "vue";
import { storeToRefs } from "pinia";
const router = inject("router");

import { useCategoryStore } from "@/stores/categoryStore";
const categoryStore = useCategoryStore();
const { categories, category, form, loading, errors } =
    storeToRefs(categoryStore);
if (!categories.length) {
    await categoryStore.getCategories();
}

const search = ref("");
const showInsert = ref(false);
</script>

<style lang="scss" scoped></style>
