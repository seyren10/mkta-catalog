<template>
    <div class="space-y-5">
        <div class="font-medium">Filter by:</div>

        <div
            v-show="hasSelectedFilter"
            class="rounded-lg bg-slate-100 p-2 text-[.75rem]"
        >
            <div
                class="mb-2 flex items-center justify-between gap-3 text-slate-500"
            >
                <span>Applied filters:</span>

                <div>
                    <v-button
                        icon="md-clearall-round"
                        density=""
                        @click="handleClearAllFilters"
                    >
                    </v-button>
                    <v-tooltip activator="parent">clear all</v-tooltip>
                </div>
            </div>
            <ul class="ml-2 space-y-2">
                <template v-for="(values, key) in selectedFilters" :key="key">
                    <li
                        class="flex items-start pb-2 [&:not(:last-of-type)]:border-b"
                        v-if="values.length"
                    >
                        <div
                            class="flex cursor-pointer items-center"
                            @click="handleClearFilter(key)"
                        >
                            <v-icon name="md-close-round" scale=".8"></v-icon>
                            <span class="mr-2 font-medium capitalize"
                                >{{ key }}:</span
                            >
                        </div>
                        <div class="flex flex-wrap gap-1">
                            <div
                                v-for="value in values"
                                :key="value"
                                class="rounded-lg bg-slate-200 px-2 text-slate-500"
                            >
                                {{ value }}
                            </div>
                        </div>
                    </li>
                </template>
            </ul>
        </div>

        <v-accordion
            bg="bg-slate-200"
            v-for="filter in filters"
            :key="filter.id"
        >
            <template #title>
                <div class="flex items-center gap-2">
                    <v-icon name="md-colorlens-outlined"></v-icon>
                    <span class="capitalize">{{ filter.title }}</span>
                </div>
            </template>

            <div class="space-y-3">
                <div v-for="choice in filter.choices" :key="choice.id">
                    <FilterCheckbox
                        :label="choice.value"
                        :value="choice"
                        :checked="
                            selectedFilters[filter.title]?.find(
                                (e) => e === choice.value,
                            )
                        "
                        @check="(e) => handleCheck(e, filter)"
                    />
                </div>
            </div>
        </v-accordion>
    </div>
</template>

<script setup>
import { storeToRefs } from "pinia";
import { computed, inject, ref } from "vue";
import { useRouter, useRoute } from "vue-router";

import FilterCheckbox from "./FilterCheckbox.vue";

//reactives

const filterStore = inject("filterStore");
const { filters } = storeToRefs(filterStore);
const selectedFilters = ref({});
const router = useRouter();
const route = useRoute();

const handleCheck = (choice, filter) => {
    const filterKey = filter.title;
    /* create an array base on filterKey */
    if (!selectedFilters.value[filterKey]){
        selectedFilters.value[filterKey] = [];
    }
    /* add the choice value on the selected filter key or remove when existing */
    if( !selectedFilters.value[filterKey].includes(choice.value) ){
        selectedFilters.value[filterKey].push(choice.value);
    }else{
        selectedFilters.value[filterKey] = selectedFilters.value[filterKey].filter((c) => c !== choice.value);
    }
    // if (!selectedFilters.value[filterKey].find((c) => c.id === choice.id)) {
    //     //add
    //     let content = {
    //         id : choice.id,
    //         value: choice.value
    //     }
    //     selectedFilters.value[filterKey].push(choice.value);
    // }else {
    //     //remove
    //     selectedFilters.value[filterKey] = selectedFilters.value[
    //         filterKey
    //     ].filter((c) => c.id !== choice.id);
    // }

    //add the query parameter
    addToQuery(filterKey);
};

const emit = defineEmits(["dataReceived"]);

const addToQuery = (filterKey) => {
    const choicesId = selectedFilters.value[filterKey].reduce((acc, cur) => {
        acc.push(cur.id);

        return acc;
    }, []);
    let filter = [];
    router.push({
        query: {
            ...route.query,
            [filterKey]: JSON.stringify(selectedFilters.value[filterKey].join(',')),
        },
    });

    emit('dataReceived', selectedFilters.value);
};

const hasSelectedFilter = computed(() => {
    return Object.keys(selectedFilters.value).length;
});

const handleClearAllFilters = () => {
    selectedFilters.value = {};

    //clear the query
    router.push({
        query: {},
    });
};

const handleClearFilter = (key) => {
    selectedFilters.value = Object.keys(selectedFilters.value).reduce(
        (acc, filterKey) => {
            if (filterKey !== key) {
                acc[filterKey] = selectedFilters.value[filterKey];
            }

            return acc;
        },
        {},
    );
    // //clear the query base on key
    const query = Object.keys(route.query).reduce((acc, routeKey) => {
        if (routeKey !== key) {
            acc[routeKey] = route.query[routeKey];
        }

        return acc;
    }, {});

    // console.log(query);
    router.push({
        query,
    });
};
</script>

<style lang="scss" scoped></style>
