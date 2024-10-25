<template>
    Filters
    <div class="ml-auto w-fit">
        <v-button
            outlined
            prepend-inner-icon="md-refresh-sharp"
            class="float-end block rounded-lg bg-accent p-2 text-white"
            @click="refreshFilter"
            >Refresh Filters</v-button
        >
    </div>
    <div class="grid grid-cols-4 gap-2">
        <div
            v-for="(filterGroup, filterGroupIndex) in filters"
            class="rounded-lg border p-2"
        >
            <div>
                <h2 class="text-2xl font-bold">{{ filterGroup.title }}</h2>
                <p class="text-gray-600">
                    {{ filterGroup.description }}
                </p>
            </div>
            <div class="grid grid-cols-2">
                <h2 class="col-span-2 mt-2 text-lg font-bold">Options</h2>
                <div v-for="option in filterGroup.choices" class="m-2 text-lg">
                    <v-button
                        @click="
                            () => {
                                if (
                                    product_filter.includes(
                                        filterGroup.id + '-' + option.id,
                                    )
                                ) {
                                    removeProductFilterChoice(
                                        filterGroup.id,
                                        option.id,
                                    );
                                } else {
                                    selectProductFilterChoice(
                                        filterGroup.id,
                                        option.id,
                                    );
                                }
                            }
                        "
                    >
                        <template #prepend-inner>
                            <v-icon
                                class="me-2 ml-auto"
                                :name="
                                    product_filter.includes(
                                        filterGroup.id + '-' + option.id,
                                    )
                                        ? 'bi-check-circle-fill'
                                        : 'bi-circle'
                                "
                                scale="1.2"
                            />
                        </template>
                        {{ option.value }}
                    </v-button>
                </div>
                <div class="col-span-2 my-2">
                    <v-button
                        outlined
                        prepend-inner-icon="bi-plus"
                        class="float-end block w-full rounded-lg bg-accent p-2 text-white"
                        @click="
                            show_AppendFilterShow(filterGroup, filterGroupIndex)
                        "
                        >New Option</v-button
                    >
                </div>
            </div>
        </div>
        <v-dialog
            v-model="showAppendFilterChoice_data.show"
            persistent
            title="Filter"
            @close="CloseFilterChoice"
        >
            <div class="grid min-w-[800px] gap-2 p-5">
                <div>
                    <h2 class="text-2xl font-bold">
                        {{ showAppendFilterChoice_data.data.title }}
                    </h2>
                    <p class="text-gray-600">
                        {{ showAppendFilterChoice_data.data.description }}
                    </p>
                </div>
                <div>
                    <v-text-field
                        v-model="showAppendFilterChoice_data.data.newChoice"
                        label="New Option"
                    />
                </div>
                <div class="flex justify-between">
                    <v-button
                        @click="CloseFilterChoice"
                        class="bg-red-400 text-white"
                    >
                        <v-icon class="me-2" name="md-close-round"></v-icon>
                        Cancel
                    </v-button>
                    <v-button
                        @click="AppendFilterChoice"
                        class="bg-green-400 text-white"
                    >
                        <v-icon class="me-2" name="md-save-round"></v-icon> Save
                        Option
                    </v-button>
                </div>
            </div>
        </v-dialog>
    </div>
</template>
<script setup>

import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";


const router = inject("router");
const props = defineProps({
    id: String,
    product_data: {}
});

const product_item = ref();
product_item.value = props.product_data;


const productStore = inject("productStore");




//!SECTION -> Filters
import { useFilterStore } from "@/stores/filterStore";
const filterStore = useFilterStore();
const { filters } = storeToRefs(filterStore);
const refreshFilter = async () => {
    await filterStore.getFilters();
};

if (!filters.length) {
    refreshFilter();
}

//!SECTION -> FilterChoice
const showAppendFilterChoice_data = ref({
    show: false,
    data: [],
    index: -1,
    newChoice: "",
});
const show_AppendFilterShow = (data, index) => {
    showAppendFilterChoice_data.value.show = true;
    showAppendFilterChoice_data.value.index = index;
    showAppendFilterChoice_data.value.data = data;
};
const CloseFilterChoice = async (filter_id) => {
    showAppendFilterChoice_data.value.index = -1;
    showAppendFilterChoice_data.value.show = false;
    showAppendFilterChoice_data.value.data = [];
};
const AppendFilterChoice = async () => {
    await filterStore.addFilterChoice(
        showAppendFilterChoice_data.value.data.id,
        { value: showAppendFilterChoice_data.value.data.newChoice },
    );
    let res = await filterStore.getFilter(
        showAppendFilterChoice_data.value.data.id,
    );
    filters.value[showAppendFilterChoice_data.value.index] = res;
    CloseFilterChoice();
};

//!SECTION
const product_filter = ref([]);
const refreshProductFilter = async () => {
    product_filter.value = await productStore.getProductFilter(product_item.value.id);
};
if(product_item.value.product_filter.length > 0){
    product_filter.value = product_item.value.product_filter;
}else{
    refreshProductFilter();
}


const selectProductFilterChoice = async (filter_id, option_id) => {
    await productStore.addProductFilter(product_item.value.id, filter_id, option_id);
    refreshProductFilter();
};
const removeProductFilterChoice = async (filter_id, option_id) => {
    await productStore.removeProductFilter(product_item.value.id, filter_id, option_id);
    refreshProductFilter();
};
</script>
