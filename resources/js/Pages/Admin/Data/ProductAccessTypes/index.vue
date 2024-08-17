<template>
    <div>
        <v-button
            prepend-inner-icon="md-refresh-sharp"
            class="my-2 border"
            @click="refresh"
            >Refresh</v-button
        >
        <v-accordion
            class="my-2"
            v-for="(accessType, accessTypeIndex) in product_access_types"
        >
            <template #title>
                <div>
                    <h2 class="text-xl font-bold">{{ accessType.title }}</h2>
                    <p class="text-gray-600">
                        {{ accessType.description }}
                    </p>
                </div>
            </template>
            <ul>
                <v-accordion
                    v-for="(data, dataIndex) in accessType.source_data"
                    class="my-2 rounded border p-2"
                >
                    <template #title>
                        <h2 class="text-lg font-bold">
                            {{ data[accessType.display_column] }}
                        </h2>
                    </template>

                    <div
                        class="grid grid-cols-1 gap-2 bg-slate-400 p-2 lg:grid-cols-2"
                    >
                        <div class="rounded-lg bg-white p-1">
                            <p>Restricted</p>
                            <div class="grid grid-cols-1 gap-2 lg:grid-cols-2">
                                <div
                                    class="flex rounded-lg border bg-white p-3"
                                    v-for="(
                                        product, ProductIndex
                                    ) in data.restricted"
                                >
                                    <smallCard :product="product">
                                        <template #append>
                                            <v-button @click="removeProduct(accessTypeIndex,dataIndex,ProductIndex, 'restricted')">
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
                                        openProductDialog(
                                            accessType,
                                            'res',
                                            data,
                                        )
                                    "
                                    class="mx-auto h-full min-h-16 w-full border bg-white"
                                >
                                    <v-icon
                                        name="bi-plus-circle-fill"
                                        class="me-2"
                                    ></v-icon>
                                    Add More
                                </v-button>
                            </div>
                        </div>
                        <div class="rounded-lg bg-white p-1">
                            <p>Exempted</p>
                            <div class="grid grid-cols-1 gap-2 lg:grid-cols-2">
                                <div
                                    class="flex rounded-lg border bg-white p-3"
                                    v-for="(
                                        product, ProductIndex
                                    ) in data.exempted"
                                >
                                    <smallCard :product="product">
                                        <template #append>
                                            <v-button @click="removeProduct(accessTypeIndex,dataIndex,ProductIndex, 'exempted')">
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
                                        openProductDialog(
                                            accessType,
                                            'ex',
                                            data,
                                        )
                                    "
                                    class="mx-auto h-full min-h-16 w-full border bg-white"
                                >
                                    <v-icon
                                        name="bi-plus-circle-fill"
                                        class="me-2"
                                    ></v-icon>
                                    Add More
                                </v-button>
                            </div>
                        </div>
                    </div>
                </v-accordion>
            </ul>
        </v-accordion>
        <div>
            <v-button
                @click="saveChanges"
                v-show="Object.keys(PAT_Changes).length > 0"
                class="m-3 border bg-green-500 text-white"
                prepend-inner-icon="md-save-round"
                >Save</v-button
            >
        </div>
    </div>
    <v-dialog
        persistent
        :title="'Products'"
        v-model="productDialog.show"
        @close="closeProductDialog"
    >
        <div class="min-w-[800px] max-w-[1200px] p-5">
            <div>
                <h2 class="text-xl font-bold">
                    {{ productDialog.data_ProductAccessType.title }}
                </h2>
                <p class="text-gray-600">
                    Select Products to
                    <b>{{
                        productDialog.mode == "res" ? "restrict" : "exempt"
                    }}</b>
                    in <b>{{ productDialog.data_SourceData.title }}</b>
                </p>
            </div>
            <ProductList
                :unlistedProducts="
                    productDialog.data_SourceData[
                        productDialog.mode == 'res' ? 'restricted' : 'exempted'
                    ].map((item) => item.id)
                "
                @close="closeProductDialog()"
                @cancel="closeProductDialog()"
                @submitSelection="submitProductDialog"
            />
        </div>
    </v-dialog>
</template>
<script setup>
import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";
const router = inject("router");

import { useProductAccessTypeStore } from "@/stores/productAccessTypeStore";
const productAccessTypeStore = useProductAccessTypeStore();
const { product_access_types, form, loading, errors } = storeToRefs(
    productAccessTypeStore,
);
const refresh = async () => {
    await productAccessTypeStore.getProductAccessTypes({
        includeOtherData: false,
        includeSourceData: true,
        includeSourceDataProducts: true,
    });
};
refresh();

//!SECTION -> Changes
const PAT_Changes = ref({});
const addChanges = (PAT, sourceData, productData, type, mode) => {
    // Initialize filter_id if it doesn't exist
    if (!Object.keys(PAT_Changes.value).includes(String(PAT.id))) {
        PAT_Changes.value[PAT.id] = {
            [sourceData.id]: {
                restricted: {
                    append: [],
                    remove: [],
                },
                exempted: {
                    append: [],
                    remove: [],
                },
            },
        };
    }
    if (
        !Object.keys(PAT_Changes.value[PAT.id]).includes(String(sourceData.id))
    ) {
        PAT_Changes.value[PAT.id][sourceData.id] = {
            restricted: {
                append: [],
                remove: [],
            },
            exempted: {
                append: [],
                remove: [],
            },
        };
    }
    PAT_Changes.value[PAT.id][sourceData.id][type][mode].push(productData.id);
};
const saveChanges = async()=>{
    await productAccessTypeStore.batchUpdate(PAT_Changes.value)
    PAT_Changes.value = {}
}


//!SECTION -> Product List
import ProductList from "../../Products/reusableComponents/Index.vue";
import smallCard from "../../Products/reusableComponents/smallCard_Product.vue";
const productDialog = ref({
    show: false,
    data_ProductAccessType: null,
    data_SourceData: null,
    mode: null,
});
const openProductDialog = (PAT, mode, data) => {
    productDialog.value.show = true;
    productDialog.value.data_ProductAccessType = PAT;
    productDialog.value.data_SourceData = data;
    productDialog.value.mode = mode;
};
const closeProductDialog = () => {
    productDialog.value.show = false;
    productDialog.value.data_ProductAccessType = null;
    productDialog.value.data_SourceData = null;
    productDialog.value.mode = null;
};
const submitProductDialog = (selected_products) => {
    selected_products.forEach((element) => {
        productDialog.value.data_SourceData[
            productDialog.value.mode == "res" ? "restricted" : "exempted"
        ].push(element);
        addChanges(
            productDialog.value.data_ProductAccessType,
            productDialog.value.data_SourceData,
            element,
            productDialog.value.mode == "res" ? "restricted" : "exempted",
            "append",
        );
    });

    closeProductDialog();
};

const removeProduct = (PAT_Index, sourceIndex, productIndex, mode )=>{
    
    addChanges(
        product_access_types.value[PAT_Index],
        product_access_types.value[PAT_Index].source_data[sourceIndex],
        product_access_types.value[PAT_Index].source_data[sourceIndex][mode][productIndex],
        mode,
        "remove"
    )
    product_access_types.value[PAT_Index].source_data[sourceIndex][mode].splice(productIndex,1)
}
</script>
