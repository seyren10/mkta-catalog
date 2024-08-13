<template>
    <div class="mb-6 pt-2">
        <div class="overflow scrollbar mx-auto !max-w-[85vw] border">
            <table
                class="table-fixed divide-y divide-gray-200"
                style="overflow-x: scroll !important"
            >
                <thead>
                    <tr class="sticky">
                        <th
                            rowspan="2"
                            class="fixed-column left-0 min-w-[200px] border-b px-4 py-2"
                        >
                            Title
                        </th>
                        <th
                            class="min-w-[200px] border-b px-4 py-2"
                            colspan="2"
                        >
                            Information
                        </th>
                        <th class="min-w-[300px]  border-b px-4 py-2" rowspan="2">Options</th>
                    </tr>
                    <tr>
                        <th class="min-w-[250px] border-b px-4 py-2">
                            Description
                        </th>
                        <th class="min-w-[250px] border-b px-4 py-2">Icon</th>
                    </tr>
                </thead>
                <tbody class="divide-gray-20 divide-y bg-slate-300">
                    <tr
                        v-for="(filter, sourceIndex) in filters"
                        :key="filter.id"
                        :class="
                            sourceIndex % 2 == 0
                                ? ' bg-slate-200 '
                                : ' bg-white '
                        "
                    >
                        <td
                            class="fixed-column sticky left-0 w-[150px] border px-4 py-2 text-center align-top"
                        >
                            <v-text-field
                                @keyup.enter="
                                    addChanges(
                                        filter.id,
                                        'title',
                                        filters[sourceIndex].title,
                                        1,
                                    )
                                "
                                persistent-hint
                                hint="Title"
                                v-model="filters[sourceIndex].title"
                            >
                            </v-text-field>
                            <pre v-show="showPre">{{ filter }}</pre>
                        </td>
                        <td class="min-w-12 border-b px-4 py-2 align-top">
                            <v-text-field
                                @keyup.enter="
                                    addChanges(
                                        filter.id,
                                        'description',
                                        filters[sourceIndex].description,
                                    )
                                "
                                persistent-hint
                                hint="Description"
                                v-model="filters[sourceIndex].description"
                            >
                            </v-text-field>
                        </td>
                        <td class="min-w-12 border-b px-4 py-2 align-top">
                            <v-text-field
                                readonly
                                :prepend-inner-icon="filter.icon"
                                persistent-hint
                                hint="Icon"
                                v-model="filter.icon"
                            >
                                <template #append-inner>
                                    <v-button
                                        @click="
                                            openIconDialog(
                                                filter.id,
                                                sourceIndex,
                                            )
                                        "
                                    >
                                        <v-icon
                                            name="hi-solid-dots-horizontal"
                                        ></v-icon>
                                    </v-button>
                                </template>
                            </v-text-field>
                        </td>
                        <td class="border-b px-4 py-2 align-top">
                            <ul class="w-full">
                                <li
                                    class="p-2"
                                    v-for="(
                                        option, optionIndex
                                    ) in filter.choices"
                                >
                                    <h2 class="text-xl font-bold">
                                        {{ option.value }}
                                    </h2>
                                    <div
                                        class="grid grid-cols-1 gap-1 md:grid-cols-2"
                                    >
                                        <div
                                            class="flex rounded-lg border bg-white p-3"
                                            v-for="(
                                                product, optionProductIndex
                                            ) in option.filter_choice_products.slice(
                                                0,
                                                3,
                                            )"
                                        >
                                            <smallCard :product="product">
                                                <template #append>
                                                    <v-button
                                                        @click="
                                                            filter_option_product_remove(
                                                                filter.id,
                                                                option.id,
                                                                optionProductIndex,
                                                            )
                                                        "
                                                    >
                                                        <v-icon
                                                            name="md-close-round"
                                                            color="white"
                                                            class="ml-auto rounded-2xl bg-red-500"
                                                            scale="1.3"
                                                        ></v-icon>
                                                    </v-button>
                                                </template>
                                            </smallCard>
                                        </div>
                                        <v-button
                                            @click="
                                                viewMoreOpen(
                                                    filter.id,
                                                    option.id,
                                                )
                                            "
                                            class="mx-auto h-full min-h-20 w-full border bg-white"
                                            v-show="
                                                option.filter_choice_products
                                                    .length > 3
                                            "
                                        >
                                            <v-icon
                                                name="hi-solid-dots-horizontal"
                                                class="me-2"
                                            ></v-icon>
                                            View More
                                        </v-button>
                                        <v-button
                                            @click="
                                                openProductDialog(
                                                    filter,
                                                    sourceIndex,
                                                    option.id,
                                                )
                                            "
                                            class="mx-auto h-full min-h-20 w-full border bg-white"
                                        >
                                            <v-icon
                                                name="bi-plus-circle-fill"
                                                class="me-2"
                                            ></v-icon>
                                            Add More
                                        </v-button>
                                    </div>
                                </li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <v-button
            @click="saveChanges"
            v-show="Object.keys(filterChanges).length > 0"
            class="m-3 border bg-green-500 text-white"
            prepend-inner-icon="md-save-round"
            >Save</v-button
        >
    </div>
    <v-dialog
        v-model="viewMore.show"
        persistent
        :title="viewMore.title"
        @close="viewMoreClose"
    >
        <div class="min-w-[80vw] max-w-[80vw] p-3 min-h-[60vh]">
            <div class="grid grid-cols-1 gap-1 md:grid-cols-4 ">
                <div
                    class="flex rounded-lg border bg-white p-3"
                    v-for="(
                        product, optionProductIndex
                    ) in viewMore.optionData.filter_choice_products"
                >
                    <smallCard :product="product">
                        <template #append>
                            <v-button
                                @click="
                                    filter_option_product_remove(
                                        viewMore.filter_ID,
                                        viewMore.option_ID,
                                        optionProductIndex,
                                    )
                                "
                            >
                                <v-icon
                                    name="md-close-round"
                                    color="white"
                                    class="ml-auto rounded-2xl bg-red-500"
                                    scale="1.3"
                                ></v-icon>
                            </v-button>
                        </template>
                    </smallCard>
                </div>
            </div>
        </div>
    </v-dialog>
    <v-dialog
        v-model="iconDialog.show"
        persistent
        title="Icon Selector"
        @close="closeIconDialog"
    >
        <div class="min-w-[80vw] max-w-[80vw] p-3 min-h-[60vh]">
            <IconViewer
                @submit="iconSelected"
                :showHeader="false"
                :isSelection="true"
            />
        </div>
    </v-dialog>
    <v-dialog
        persistent
        :title="'Products'"
        v-model="productDialog.show"
        @close="closeProductDialog"
    >
        <div class="min-w-[800px] max-w-[1200px] p-5">
            <ProductList
                :unlistedProducts="productDialog.sourceData.all_product_id"
                @close="closeProductDialog()"
                @cancel="closeProductDialog()"
                @submitSelection="submitProductDialog"
            />
        </div>
    </v-dialog>
</template>
<style scoped>
table td {
    border: 1px black !important;
}
.fixed-column {
    position: sticky;
    left: 0;
    background: #fff; /* Ensure it’s visible */
    z-index: 1; /* Ensure it stays above other content */
}
.scrollable-table {
    display: block;
    overflow-x: auto;
}
.table-wrapper {
    display: block;
    max-width: 100%;
    overflow-x: auto;
}
.overflow {
    overflow-x: scroll !important;
}
.autofit {
    width: auto;
    white-space: nowrap;
}
</style>
<script setup>
import smallCard from "../../Products/reusableComponents/smallCard_Product.vue";
import ProductList from "../../Products/reusableComponents/Index.vue";
import IconViewer from "../../Icons/Index.vue";

import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";

const showPre = ref(false);
const router = inject("router");
const s3 = inject("s3");

import { useFilterStore } from "@/stores/filterStore";
const filterStore = useFilterStore();
const { filters } = storeToRefs(filterStore);
const refresh = async () => {
    await filterStore.getFilters();
};
if (!filters.length) {
    refresh();
}
const filterChanges = ref({});
const addChanges = (
    filter_id,
    column,
    value,
    option_id = -1,
    type = "append",
) => {
    // Initialize filter_id if it doesn't exist
    if (!Object.keys(filterChanges.value).includes(String(filter_id))) {
        filterChanges.value[filter_id] = {
            data: {},
            options: [],
        };
    }
    // Handle the different column types
    if (column === "optionsValue") {
        // Ensure container has a list for the data key
        if (
            !Object.keys(filterChanges.value[filter_id].options).includes(
                String(option_id),
            )
        ) {
            filterChanges.value[filter_id].options = {
                ...filterChanges.value[filter_id].options,
                [option_id]: {
                    append: [],
                    remove: [],
                },
            };
        }
        filterChanges.value[filter_id].options[option_id][type].push(value);
        if(type === 'remove'){
            let itemIndex = filterChanges.value[filter_id].options[option_id]['append'].findIndex( element => element.id === value )
            while(itemIndex != -1){
                filterChanges.value[filter_id].options[option_id]['append'].splice(itemIndex, 1)
                itemIndex = filterChanges.value[filter_id].options[option_id]['append'].findIndex( element => element.id === value )
            }
        }else{
            let itemIndex = filterChanges.value[filter_id].options[option_id]['remove'].findIndex( element => element.id === value.id )
            while(itemIndex != -1){
                filterChanges.value[filter_id].options[option_id]['remove'].splice(itemIndex, 1)
                itemIndex = filterChanges.value[filter_id].options[option_id]['remove'].findIndex( element => element.id === value.id )
            }
        }
    } else {
        // Update or add the data field
        filterChanges.value[filter_id].data = {
            ...filterChanges.value[filter_id].data,
            [column]: value,
        };
    }
};
const saveChanges = async()=>{
    await filterStore.batchUpdate({ filters : filterChanges.value });
    refresh();
    filterChanges.value = {}
}
//!SECTION -> Filter Option Product Actions
const filter_option_product_append = (filter_id, option_id, productData) => {
    let filterIndex = filters.value.findIndex(
        (filter) => filter.id === filter_id,
    );
    if (filterIndex == -1) {
        return;
    }
    let optionIndex = filters.value[filterIndex].choices.findIndex(
        (option) => option.id === option_id,
    );
    if (optionIndex == -1) {
        return;
    }
    filters.value[filterIndex].all_product_id.push(productData.id);
    filters.value[filterIndex].choices[optionIndex].filter_choice_products.push(
        productData,
    );
    addChanges(
        filters.value[filterIndex].id,
        "optionsValue",
        productData,
        filters.value[filterIndex].choices[optionIndex].id,
        "append",
    );
};
const filter_option_product_remove = (filter_id, option_id, productIndex) => {
    let filterIndex = filters.value.findIndex(
        (filter) => filter.id === filter_id,
    );
    if (filterIndex == -1) {
        return;
    }
    let optionIndex = filters.value[filterIndex].choices.findIndex(
        (option) => option.id === option_id,
    );
    if (optionIndex == -1) {
        return;
    }
    let TempData =
        filters.value[filterIndex].choices[optionIndex].filter_choice_products[
            productIndex
        ];
    filters.value[filterIndex].choices[
        optionIndex
    ].filter_choice_products.splice(productIndex, 1);

    let curproductIndex = filters.value[filterIndex].all_product_id.findIndex(
        (element) => element === TempData.id,
    );
    addChanges(
        filters.value[filterIndex].id,
        "optionsValue",
        filters.value[filterIndex].all_product_id[curproductIndex],
        filters.value[filterIndex].choices[optionIndex].id,
        "remove",
    );
    filters.value[filterIndex].all_product_id.splice(curproductIndex, 1);
};

//!SECTION -> ViewMore Data
const viewMore = ref({
    show: false,
    title: "",

    filterData: null,
    filter_ID: -1,
    filter_Index: -1,

    optionData: null,
    option_ID: -1,
    option_Index: -1,
});
const viewMoreOpen = (filter_id, option_id) => {
    let filterIndex = filters.value.findIndex(
        (filter) => filter.id === filter_id,
    );
    if (filterIndex == -1) {
        return;
    }
    let optionIndex = filters.value[filterIndex].choices.findIndex(
        (option) => option.id === option_id,
    );
    if (optionIndex == -1) {
        return;
    }

    viewMore.value.show = true;
    viewMore.value.title =
        filters.value[filterIndex].title +
        " - " +
        filters.value[filterIndex].choices[optionIndex].value;

    viewMore.value.filterData = filters.value[filterIndex];
    viewMore.value.filter_ID = filter_id;
    viewMore.value.filter_Index = filterIndex;

    viewMore.value.optionData = filters.value[filterIndex].choices[optionIndex];
    viewMore.value.option_ID = option_id;
    viewMore.value.option_Index = optionIndex;
};
const viewMoreClose = () => {
    viewMore.value.filterData   = null
    viewMore.value.filter_ID    = -1
    viewMore.value.filter_Index = -1

    viewMore.value.optionData   = null
    viewMore.value.option_ID    = -1
    viewMore.value.option_Index = -1
};

//!SECTION - Icon Dialog
const iconDialog = ref({
    show: false,
    sourceIndex: -1,
    sourceID: -1,
});
const openIconDialog = (filter_id, filter_index) => {
    iconDialog.value.sourceID = filter_id;
    iconDialog.value.sourceIndex = filter_index;
    iconDialog.value.show = true;
};
const closeIconDialog = () => {
    iconDialog.value.sourceID = -1;
    iconDialog.value.sourceIndex = -1;
    iconDialog.value.show = false;
};
const iconSelected = (selected_icon) => {
    filters.value[iconDialog.value.sourceIndex].icon = selected_icon;
    addChanges(iconDialog.value.sourceID, "icon", selected_icon);
    closeIconDialog();
};

//!SECTION - Product Dialog
const productDialog = ref({
    show: false,
    sourceIndex: -1,
    sourceData: null,
    optionID: -1,
});
const openProductDialog = (data, sourceIndex, optionID) => {
    productDialog.value.optionID = optionID;
    productDialog.value.sourceData = data;
    productDialog.value.sourceIndex = sourceIndex;
    productDialog.value.show = true;
    
};
const closeProductDialog = () => {
    productDialog.value.optionID = -1;
    productDialog.value.sourceData = null;
    productDialog.value.sourceIndex = -1;
    productDialog.value.show = false;
};
const submitProductDialog = (selected_products) => {
    let filterIndex = filters.value.findIndex(
        (filter) => filter.id === productDialog.value.sourceData.id,
    );
    if (filterIndex == -1) {
        return;
    }
    let optionIndex = filters.value[filterIndex].choices.findIndex(
        (option) => option.id === productDialog.value.optionID,
    );
    if (optionIndex == -1) {
        return;
    }

    selected_products.forEach((element) => {
        filter_option_product_append(
            productDialog.value.sourceData.id,
            productDialog.value.optionID,
            element,
        );

        addChanges(
            productDialog.value.sourceData.id,
            "optionsValue",
            element,
            filters.value[filterIndex].choices[optionIndex].id,
            "append",
        );
    });

    closeProductDialog();
};
</script>
