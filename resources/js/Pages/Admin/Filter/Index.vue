<template>
    <div class="pt-2 grid gap-2">
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
                prepend-inner-icon="hi-solid-filter"
                class="float-end block rounded-lg bg-accent p-2 text-white"
                @click="showInsertFilter = true"
                >New Filter</v-button
            >
        </div>
        <v-text-field
                prepend-inner-icon="la-search-solid"
                v-model="search"
                clearable
            ></v-text-field>
        <v-data-table
            :search="search"
            :items="filters"
            :headers="[
                {
                    value: '',
                    key: 'id',
                    hidden: true,
                    sortable: false,
                },
                {
                    value: 'Title',
                    key: 'title',
                    hidden: false,
                    sortable: false,
                },
                {
                    value: '# of Options',
                    key: 'count',
                    hidden: false,
                    sortable: false,
                },
                {
                    value: '',
                    key: 'actions',
                    hidden: false,
                    sortable: false,
                },
            ]"
        >
            <template #item.title="{ item }">
                <h2 class="text-xl font-bold">{{ item.value }}</h2>
                <p class="text-gray-600">
                    {{ item.raw.description }}
                </p>
            </template>

            <template #item.count="{ item }">
                {{ item.raw.choices.length }}
            </template>
            <template #item.actions="{item}">
                <div class="flex justify-end">
                    <div class="max-w-[150px]">
                        <v-button
                            class="w-full bg-red-600 text-white"
                            @click="deleteFilter(item.raw.id)"
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
                                        name: 'productFilterShow',
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
                </div>
            </template>
        </v-data-table>
        <v-dialog
            v-model="showInsertFilter"
            persistent
            title="Filter"
            @close="closeInsertFilter"
        >
            <div class="min-w-[800px] p-5">
                <FilterInsert
                @submit="closeInsertFilter"
                @cancel="closeInsertFilter"
                />
            </div>
        </v-dialog>
        
    </div>
</template>
<script setup>
import FilterInsert from "./Insert.vue";

import { onBeforeMount, inject, ref, watch } from "vue";
import { storeToRefs } from "pinia";
const router = inject("router");


const search = ref("");

import { useFilterStore } from "@/stores/filterStore";
const filterStore = useFilterStore();
const { filters } = storeToRefs(filterStore);
const refresh = async () => {
    await filterStore.getFilters();
};
if (!filters.length) {
    refresh();
}

const showInsertFilter = ref(false);
const closeInsertFilter = ()=>{
    showInsertFilter.value = false
    refresh();
}

const deleteFilter = async(filter_id) =>{
    await filterStore.deleteFilter(filter_id)
    refresh();
}
</script>

<style lang="scss" scoped></style>
