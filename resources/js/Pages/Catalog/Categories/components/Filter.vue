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
        <v-accordion bg="bg-slate-200" expanded>
            <template #title>
                <div class="flex items-center gap-2">
                    <v-icon name="md-colorlens-outlined"></v-icon>
                    <span>Colors</span>
                </div>
            </template>

            <div class="space-y-3">
                <v-checkbox
                    v-model="selectedColors"
                    value="red"
                    label="Red"
                ></v-checkbox>
                <v-checkbox
                    v-model="selectedColors"
                    value="blue"
                    label="Blue"
                ></v-checkbox>
                <v-checkbox
                    v-model="selectedColors"
                    value="pink"
                    label="Pink"
                ></v-checkbox>
                <v-checkbox
                    v-model="selectedColors"
                    value="green"
                    label="Green"
                ></v-checkbox>
                <v-checkbox
                    v-model="selectedColors"
                    value="yellow"
                    label="Yellow"
                ></v-checkbox>
                <v-checkbox
                    v-model="selectedColors"
                    value="aquamarine"
                    label="Aquamarine"
                ></v-checkbox>
            </div>
        </v-accordion>

        <v-accordion bg="bg-slate-200">
            <template #title>
                <div class="flex items-center gap-2">
                    <v-icon name="la-cog-solid"></v-icon>
                    <span>Product Types</span>
                </div>
            </template>

            <div class="space-y-3">
                <v-checkbox
                    v-model="selectedTypes"
                    value="inlitefi"
                    label="InliteFi"
                ></v-checkbox>
                <v-checkbox
                    v-model="selectedTypes"
                    value="fiberglass"
                    label="Fiberglass"
                ></v-checkbox>
            </div>
        </v-accordion>

        <v-accordion bg="bg-slate-200">
            <template #title>
                <div class="flex items-center gap-2">
                    <v-icon name="md-spacebar-round"></v-icon>
                    <span>Spatial</span>
                </div>
            </template>

            <div class="space-y-3">
                <v-checkbox
                    v-model="selectedSpatial"
                    value="indoor"
                    label="Indoor"
                ></v-checkbox>
                <v-checkbox
                    v-model="selectedSpatial"
                    value="outdoor"
                    label="Outdoor"
                ></v-checkbox>
            </div>
        </v-accordion>
    </div>
</template>

<script setup>
import { computed, ref } from "vue";

//reactives
const selectedColors = ref([]);
const selectedTypes = ref([]);
const selectedSpatial = ref([]);

//computed
const hasSelectedFilter = computed(() => {
    return (
        [
            ...selectedColors.value,
            ...selectedTypes.value,
            ...selectedSpatial.value,
        ].length > 0
    );
});

const selectedFilters = computed(() => {
    return {
        colors: selectedColors.value,
        types: selectedTypes.value,
        spatial: selectedSpatial.value,
    };
});

//methods
const handleClearFilter = (filterType) => {
    switch (filterType) {
        case "colors":
            selectedColors.value = [];
            break;
        case "types":
            selectedTypes.value = [];
            break;
        case "spatial":
            selectedSpatial.value = [];
            break;
    }
};

const handleClearAllFilters = () => {
    selectedColors.value = [];
    selectedTypes.value = [];
    selectedSpatial.value = [];
};
</script>

<style lang="scss" scoped></style>
