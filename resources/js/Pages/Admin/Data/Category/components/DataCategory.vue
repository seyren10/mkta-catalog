<template>
    <div class="my-2 pl-5 text-xl">
        <v-accordion>
            <template #title> {{ data.title }} </template>
            <div
                class="grid grid-cols-2 gap-2"
                v-if="data.sub_categories.length == 0"
            >
                <div
                    class="flex rounded-lg border bg-white p-3"
                    v-for="(product, productIndex) in data.products"
                >
                    <smallCard :product="product.product_data">
                        <template #append>
                            <v-button
                                @click="
                                    removeProduct(
                                        productIndex,
                                        product.product_data,
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
                    class="mx-auto h-full min-h-20 w-full border bg-white"
                    @click="productDialogOpen(data)"
                >
                    <v-icon name="bi-plus-circle-fill" class="me-2"></v-icon>
                    Add More
                </v-button>
                <div class="col-span-2">
                    <v-button
                        @click="save"
                        class="ml-auto rounded-md border bg-green-500 text-white"
                        ><v-icon name="md-save-round" class="me-2"></v-icon
                        >Save</v-button
                    >
                </div>
            </div>
            <ul v-if="Array.isArray(data.sub_categories)">
                <li
                    v-for="(subCategory, index) in data.sub_categories"
                    :key="index"
                >
                    <DataCategory :data="subCategory" />
                </li>
            </ul>
        </v-accordion>
    </div>
    <v-dialog
        persistent
        title="Products"
        v-model="productDialog_Data.showDialog"
        @close="productDialogClose()"
    >
        <div class="min-w-[800px] max-w-[1200px] p-5">
            <ProductList
                :unlistedProducts="
                    data.products.map((product) => product.product_id)
                "
                @close="productDialogClose()"
                @cancel="productDialogClose()"
                @submitSelection="productDialogSubmit"
            />
        </div>
    </v-dialog>
</template>

<script setup>
import smallCard from "../../../Products/reusableComponents/smallCard_Product.vue";
import ProductList from "../../../Products/reusableComponents/Index.vue";
import { inject, ref } from "vue";
const props = defineProps({
    data: {
        type: Object,
        default: {
            id: null,
            title: null,
            parent_id: null,
            products: [],
            sub_categories: [],
        },
    },
});
const categoryStore = inject("categoryStore");
//!SECTION -> Product Changes
const product_changes = ref({
    data: {
        id: props.data.id,
        parent_id: props.data.parent_id,
    },
    remove: [],
    append: [],
});
const addChanges = (mode, product) => {
    product_changes.value[mode].push(product.id);
};
const removeProduct = (productIndex, product) => {
    addChanges("remove", product);
    props.data.products.splice(productIndex, 1);
};
const save = () => {
    categoryStore.batchUpdate(product_changes.value);
    product_changes.value = {
        data: {
            id: props.data.id,
            parent_id: props.data.parent_id,
        },
        remove: [],
        append: [],
    };
};
//!SECTION -> Product List
const productDialog_Data = ref({
    showDialog: false,
    data: null,
});
const productDialogOpen = (data) => {
    productDialog_Data.value.showDialog = true;
    productDialog_Data.value.data = data;
};
const productDialogClose = () => {
    productDialog_Data.value.showDialog = false;
    productDialog_Data.value.data = null;
};
const productDialogSubmit = async (selected_products) => {
    selected_products.forEach((element) => {
        addChanges("append", element);
        props.data.products.push({
            product_id: element.id,
            product_data: element,
            category_id: props.data.id,
        });
    });
    productDialogClose();
};
</script>
