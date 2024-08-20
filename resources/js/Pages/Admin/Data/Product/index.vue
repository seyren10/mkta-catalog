<template>
    <div class="mb-6 pt-2">
        <v-accordion :open="true" class="mb-2 border text-xl">
            <template #title> Product Information </template>
            <div class="grid grid-cols-3 gap-2">
                <v-checkbox
                    v-model="data.value"
                    v-for="(data, index) in request"
                    :label="data.text"
                />
            </div>
        </v-accordion>
        <div :disabled="Object.keys(productChanges).length > 0">
            <v-text-field
                @keyup.enter="refresh"
                prepend-inner-icon="la-search-solid"
                v-model="search"
                :disabled="Object.keys(productChanges).length > 0"
            />
            <pagination
                @page-change="handlePageChange"
                :items="paginationLinks"
            />
            <p v-show="Object.keys(productChanges).length > 0">
                Changes must be save in order to change the Page or refresh the
                page to clear the changes
            </p>
        </div>

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
                            Code
                        </th>
                        <th
                            v-show="request.includeProductInformation.value"
                            class="min-w-[200px] border-b px-4 py-2"
                            colspan="3"
                        >
                            Product Info
                        </th>
                        <th
                            v-show="request.includeProductDimensions.value"
                            class="min-w-[200px] border-b px-4 py-2"
                            rowspan="2"
                            colspan="1"
                        >
                            Dimensions
                        </th>
                        <th
                            v-show="request.includeProductWeight.value"
                            class="min-w-[200px] border-b px-4 py-2"
                            rowspan="2"
                            colspan="1"
                        >
                            Weight
                        </th>
                        <th
                            v-show="request.includeProductVolume.value"
                            class="min-w-[200px] border-b px-4 py-2"
                            rowspan="2"
                            colspan="1"
                        >
                            Volume
                        </th>
                        <th
                            v-show="request.includeProductRelated.value"
                            class="min-w-[300px] border-b px-4 py-2"
                            rowspan="2"
                            colspan="1"
                        >
                            Related Products
                        </th>
                        <th
                            v-show="request.includeProductRecommended.value"
                            class="min-w-[300px] border-b px-4 py-2"
                            rowspan="2"
                            colspan="1"
                        >
                            Recommended Products
                        </th>
                    </tr>
                    <tr>
                        <th
                            v-show="request.includeProductInformation.value"
                            class="min-w-[250px] border-b px-4 py-2"
                        >
                            Parent
                        </th>
                        <th
                            v-show="request.includeProductInformation.value"
                            class="min-w-[250px] border-b px-4 py-2"
                        >
                            Title
                        </th>
                        <th
                            v-show="request.includeProductInformation.value"
                            class="min-w-[400px] border-b px-4 py-2"
                        >
                            Description
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-gray-20 divide-y bg-slate-500">
                    <tr
                        v-for="(item, sourceIndex) in product_items"
                        :key="item.id + '_' + sourceIndex"
                        :class="
                            sourceIndex % 2 == 0
                                ? ' bg-slate-400 '
                                : ' bg-white '
                        "
                    >
                        <td
                            class="fixed-column sticky left-0 border px-4 py-2 text-center align-top"
                        >
                            <p class="text-xl">{{ item.id }}</p>
                        </td>
                        <td
                            class="min-w-12 border-b px-4 py-2 align-top"
                            v-show="request.includeProductInformation.value"
                        >
                            <v-text-field
                                @keyup.enter="
                                    addChanges(
                                        item.id,
                                        'data',
                                        'parent_code',
                                        item.parent_code,
                                    )
                                "
                                persistent-hint
                                hint="Parent"
                                v-model="item.parent_code"
                            >
                            </v-text-field>
                        </td>
                        <td
                            class="min-w-12 border-b px-4 py-2 align-top"
                            v-show="request.includeProductInformation.value"
                        >
                            <v-text-field
                                persistent-hint
                                hint="Title"
                                v-model="item.title"
                                @keyup.enter="
                                    addChanges(
                                        item.id,
                                        'data',
                                        'title',
                                        item.title,
                                    )
                                "
                            >
                            </v-text-field>
                        </td>
                        <td
                            class="min-w-12 border-b px-4 py-2 align-top"
                            v-show="request.includeProductInformation.value"
                        >
                            <v-textarea
                                persistent-hint
                                hint="Description"
                                rows="10"
                                @keyup.enter="
                                    addChanges(
                                        item.id,
                                        'data',
                                        'description',
                                        item.description,
                                    )
                                "
                                v-model="item.description"
                            >
                            </v-textarea>
                        </td>

                        <td
                            class="grid min-w-12 gap-2 border-b px-4 py-2 align-top"
                            v-show="request.includeProductDimensions.value"
                        >
                            <v-text-field
                                type="number"
                                persistent-hint
                                label="Length"
                                v-model="item.dimension_length"
                                @keyup.enter="
                                    addChanges(
                                        item.id,
                                        'data',
                                        'dimension_length',
                                        item.dimension_length,
                                    )
                                "
                            >
                                <template #append-inner> cm </template>
                            </v-text-field>
                            <v-text-field
                                type="number"
                                persistent-hint
                                label="Width"
                                v-model="item.dimension_width"
                                @keyup.enter="
                                    addChanges(
                                        item.id,
                                        'data',
                                        'dimension_width',
                                        item.dimension_width,
                                    )
                                "
                            >
                                <template #append-inner> cm </template>
                            </v-text-field>
                            <v-text-field
                                type="number"
                                persistent-hint
                                label="Height"
                                v-model="item.dimension_height"
                                @keyup.enter="
                                    addChanges(
                                        item.id,
                                        'data',
                                        'dimension_height',
                                        item.dimension_height,
                                    )
                                "
                            >
                                <template #append-inner> cm </template>
                            </v-text-field>
                        </td>
                        <!-- <td></td> -->
                        <td
                            class="grid min-w-12 gap-2 border-b px-4 py-2 align-top"
                            v-show="request.includeProductWeight.value"
                        >
                            <v-text-field
                                persistent-hint
                                label="Net"
                                v-model="item.weight_net"
                                @keyup.enter="
                                    addChanges(
                                        item.id,
                                        'data',
                                        'weight_net',
                                        item.weight_net,
                                    )
                                "
                            >
                                <template #append-inner> kgs </template>
                            </v-text-field>
                            <v-text-field
                                persistent-hint
                                label="Gross"
                                v-model="item.weight_gross"
                                @keyup.enter="
                                    addChanges(
                                        item.id,
                                        'data',
                                        'weight_gross',
                                        item.weight_gross,
                                    )
                                "
                            >
                                <template #append-inner> kgs </template>
                            </v-text-field>
                        </td>

                        <td
                            class="min-w-12 border-b px-4 py-2 align-top"
                            v-show="request.includeProductVolume.value"
                        >
                            <v-text-field
                                persistent-hint
                                label="Volume"
                                v-model="item.volume"
                                @keyup.enter="
                                    addChanges(
                                        item.id,
                                        'data',
                                        'volume',
                                        item.volume,
                                    )
                                "
                            >
                                <template #append-inner>
                                    m<sup>3</sup>
                                </template>
                            </v-text-field>
                        </td>
                        <td
                            class="min-w-12 border-b px-4 py-2 align-top"
                            v-show="request.includeProductRelated.value"
                        >
                            <ul class="grid gap-1 divide-slate-300">
                                <li
                                    class="flex cursor-pointer gap-3 rounded-lg bg-slate-200 p-2 hover:bg-white"
                                    v-for="(
                                        related, relIndex
                                    ) in item.related_product.slice(0, 3)"
                                >
                                    <smallCard :product="related.product">
                                        <template #append>
                                            <v-icon
                                                @click="
                                                    () => {
                                                        removeRelatedProduct(
                                                            related,
                                                        );
                                                        removeFromSource(
                                                            sourceIndex,
                                                            relIndex,
                                                            'related_product',
                                                        );
                                                    }
                                                "
                                                name="md-close-round"
                                                color="white"
                                                class="ml-auto rounded-2xl bg-red-500"
                                                scale="1.3"
                                            ></v-icon>
                                        </template>
                                    </smallCard>
                                </li>
                                <li
                                    v-show="item.related_product.length > 3"
                                    @click="
                                        viewMoreOpen(
                                            item,
                                            'Related',
                                            item.related_product,
                                            sourceIndex,
                                        )
                                    "
                                    class="flex cursor-pointer gap-3 rounded-lg bg-slate-200 p-2 hover:bg-white"
                                >
                                    <v-button class="mx-auto">
                                        <v-icon
                                            name="hi-solid-dots-horizontal"
                                            class="me-2"
                                        ></v-icon>
                                        View More</v-button
                                    >
                                </li>
                                <li
                                    class="flex w-full cursor-pointer gap-3 rounded-lg bg-slate-200 p-2 hover:bg-white"
                                >
                                    <v-button
                                        class="mx-auto"
                                        @click="
                                            dialogOpen(
                                                item.id,
                                                'Related',
                                                sourceIndex,
                                            )
                                        "
                                    >
                                        <v-icon
                                            name="bi-plus-circle-fill"
                                            class="me-2"
                                        ></v-icon>
                                        Add Related Products</v-button
                                    >
                                </li>
                            </ul>
                        </td>
                        <td
                            class="min-w-12 border-b px-4 py-2 align-top"
                            v-show="request.includeProductRecommended.value"
                        >
                            <ul class="grid gap-1 divide-slate-300">
                                <li
                                    class="flex cursor-pointer gap-3 rounded-lg bg-slate-200 p-2 hover:bg-white"
                                    v-for="(
                                        recommended, recIndex
                                    ) in item.recommended_product.slice(0, 3)"
                                >
                                    <smallCard :product="recommended.product">
                                        <template #append>
                                            <v-icon
                                                @click="
                                                    () => {
                                                        removeRecommededProduct(
                                                            recommended,
                                                        );
                                                        removeFromSource(
                                                            sourceIndex,
                                                            recIndex,
                                                            'recommended_product',
                                                        );
                                                    }
                                                "
                                                name="md-close-round"
                                                color="white"
                                                class="ml-auto rounded-2xl bg-red-500"
                                                scale="1.3"
                                            ></v-icon>
                                        </template>
                                    </smallCard>
                                </li>
                                <li
                                    @click="
                                        viewMoreOpen(
                                            item,
                                            'Recommended',
                                            item.recommended_product,
                                            sourceIndex,
                                        )
                                    "
                                    v-show="item.recommended_product.length > 3"
                                    class="flex cursor-pointer gap-3 rounded-lg bg-slate-200 p-2 hover:bg-white"
                                >
                                    <v-button class="mx-auto">
                                        <v-icon
                                            name="hi-solid-dots-horizontal"
                                            class="me-2"
                                        ></v-icon>
                                        View More</v-button
                                    >
                                </li>
                                <li
                                    class="flex w-full cursor-pointer gap-3 rounded-lg bg-slate-200 p-2 hover:bg-white"
                                >
                                    <v-button
                                        class="mx-auto"
                                        @click="
                                            dialogOpen(
                                                item.id,
                                                'Recommended',
                                                sourceIndex,
                                            )
                                        "
                                    >
                                        <v-icon
                                            name="bi-plus-circle-fill"
                                            class="me-2"
                                        ></v-icon>
                                        Add Recommended Products</v-button
                                    >
                                </li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <v-button
            v-show="Object.keys(productChanges).length > 0"
            @click="saveChanges"
            class="m-3 ml-auto border bg-green-500 text-white"
            prepend-inner-icon="md-save-round"
            >Save</v-button
        >
    </div>
    <v-dialog
        persistent
        :title="viewMore.mode + ' Products'"
        v-model="viewMore.showDialog"
        @close="viewMoreClose"
    >
        <div
            class="grid min-w-[800px] max-w-[1200px] grid-cols-1 gap-2 p-5 md:grid-cols-3"
        >
            <div
                class="rounded-lg border p-2"
                v-for="(item, viewMoredIndex) in viewMore.data"
            >
                <smallCard :product="item.product">
                    <template #prepend>
                        <div class="w-full">
                            <div class="m-0 ml-auto w-fit p-0">
                                <v-button
                                    class="m-0 p-0"
                                    @click="
                                        () => {
                                            removeFromSource(
                                                viewMore.sourceIndex,
                                                viewMoredIndex,
                                                viewMore.mode == 'Related'
                                                    ? 'related_product'
                                                    : 'recommended_product',
                                            );

                                            viewMoreRemove(item);
                                        }
                                    "
                                    ><v-icon
                                        name="md-close-round"
                                        color="white"
                                        class="rounded-2xl bg-red-500"
                                        scale="1.3"
                                    ></v-icon
                                ></v-button>
                            </div>
                        </div>
                    </template>
                </smallCard>
            </div>
        </div>
    </v-dialog>
    <v-dialog
        persistent
        :title="productDialog_Data.mode + ' Products'"
        v-model="productDialog_Data.showDialog"
        @close="dialogClose"
    >
        <div class="min-w-[800px] max-w-[1200px] p-5">
            <v-checkbox
                v-model="productDialog_Data.bothWays"
                label="Append in the selected Product Items"
            />
            <ProductList
                @close="dialogClose()"
                @cancel="dialogClose()"
                @submitSelection="dialogSubmit"
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
import checkboxDataCategory from "./components/checkboxDataCategory.vue";
import ProductList from "../../Products/reusableComponents/Index.vue";
import { onBeforeMount, ref, watch, computed, inject } from "vue";
import smallCard from "../../Products/reusableComponents/smallCard_Product.vue";
import pagination from "@/components/PaginationLinks.vue";
const router = inject("router");
const s3 = inject("s3");
import { useQuery } from "@/composables/useQuery";

const request = ref({
    includeProductInformation: {
        text: "Product Information",
        value: true,
    },
    includeProductDimensions: {
        text: "Product Dimensions",
        value: true,
    },
    includeProductWeight: {
        text: "Product Weight",
        value: true,
    },
    includeProductVolume: {
        text: "Product Volume",
        value: !true,
    },
    includeProductRelated: {
        text: "Related Products",
        value: !true,
    },
    includeProductRecommended: {
        text: "Recommended Products",
        value: !true,
    },
});
const collections = ref({});
//!SECTION -> For Search
import { storeToRefs } from "pinia";
import { useProductStore } from "@/stores/productStore";
const productStore = useProductStore();
const { product_items, isValid, paginationLinks } = storeToRefs(productStore);
const showInsert = ref(false);
const [page, setPage] = useQuery("page", () => refresh());
const [searchQuery, setSearchQuery] = useQuery("search", () => refresh());
const search = ref(searchQuery.value);
const tempProductItems = ref([]);
const refresh = async () => {
    setSearchQuery(search.value);

    let requestData = {
        q: searchQuery.value,
        page: page.value,
        includeProductDimensions: true,
        includeParentCode: true,
        includeProductVolume: true,
        includeProductWeight: true,
        includeRelatedProducts: true,
        includeRecommendedProduct: true,
        includeProductCategories: true,
        includeProductCategoryKeys: true,
    };
    await productStore.getProductItems({
        ...requestData,
    });
    product_items.value.forEach((item) => {
        collections.value[item.id] = item.product_category_keys;
    });
};
if (!product_items.length) {
    refresh();
}
const handlePageChange = (page) => {
    if (page.url === null) return;
    const pageNumber = page.url.match(/[?&]page=(\d+)/)?.at(1);
    setPage(+pageNumber);
};

//!SECTION -> Categories
import { useCategoryStore } from "@/stores/categoryStore";
const categoryStore = useCategoryStore();
const { categories, category, form, loading, errors } =
    storeToRefs(categoryStore);
if (!categories.length) {
    await categoryStore.getCategories({ includeSubCategories: true });
}
const categoryChange = (data, product_id, product_index) => {
    // addChanges(product_id, "cat_data", null, product_items.value[product_index].product_category_keys);
};

//!SECTION -> Changes
const productChanges = ref({});
const addChanges = (product_id, container, data, value) => {
    // Check if product_id exists in productChanges
    if (!Object.keys(productChanges.value).includes(product_id)) {
        productChanges.value[product_id] = {
            prod_data: {},
            cat_data: {},
            related: {
                append: [],
                remove: [],
            },
            recommended: {
                append: [],
                remove: [],
            },
        };
    }

    // Handle the different container types
    if (container === "data") {
        // Update prod_data
        productChanges.value[product_id].prod_data = {
            ...productChanges.value[product_id].prod_data,
            ...{ [data]: value },
        };
    } else if (container === "cat_data") {
        // Update category
        productChanges.value[product_id].cat_data = value;
    } else if (container === "related" || container === "recommended") {
        // Ensure container has a list for the data key
        if (!productChanges.value[product_id][container][data]) {
            productChanges.value[product_id][container][data] = [];
        }
        productChanges.value[product_id][container][data].push(value);
    } else {
        console.error(`Invalid container: ${container}`);
    }
};
const saveChanges = async () => {
    productStore.tablebatch_updateProducts(productChanges.value);
    productChanges.value = {};
    refresh();
};
//!SECTION -> Link Store
import { useLinkProductStore } from "@/stores/linkProductStore";
const linkProductStore = useLinkProductStore();
//!SECTION -> For Recommended and Related Products
const productDialog_Data = ref({
    showDialog: false,
    sourceProduct: null,
    sourceIndex: -1,
    bothWays: false,
    mode: null,
    selected: null,
});
const dialogOpen = (product_id, mode, sourceIndex) => {
    productDialog_Data.value.showDialog = true;
    productDialog_Data.value.sourceProduct = product_id;
    productDialog_Data.value.sourceIndex = sourceIndex;
    productDialog_Data.value.mode = mode;
    productDialog_Data.value.selected = null;
};
const dialogClose = () => {
    productDialog_Data.value.showDialog = false;
    productDialog_Data.value.sourceProduct = null;
    productDialog_Data.value.sourceIndex = -1;

    productDialog_Data.value.mode = null;
    productDialog_Data.value.selected = null;
};
const dialogSubmit = async (selected_products) => {
    selected_products.forEach(async (element) => {
        if (productDialog_Data.value.mode === "Related") {
            addChanges(
                productDialog_Data.value.sourceProduct,
                "related",
                "append",
                element.id,
            );
            if (productDialog_Data.value.bothWays) {
                addChanges(
                    element.id,
                    "related",
                    "append",
                    productDialog_Data.value.sourceProduct,
                );
            }

            addFromSource(
                productDialog_Data.value.sourceIndex,
                productDialog_Data.value.mode,
                element,
            );
        }
        if (productDialog_Data.value.mode === "Recommended") {
            addChanges(
                productDialog_Data.value.sourceProduct,
                "recommended",
                "append",
                element.id,
            );
            if (productDialog_Data.value.bothWays) {
                addChanges(
                    element.id,
                    "recommended",
                    "append",
                    productDialog_Data.value.sourceProduct,
                );
            }
            addFromSource(
                productDialog_Data.value.sourceIndex,
                productDialog_Data.value.mode,
                element,
            );
        }
    });
    dialogClose();
};
const removeRecommededProduct = async (data) => {
    addChanges(data.product_id, "recommended", "remove", data.product.id);
};
const removeRelatedProduct = async (data) => {
    addChanges(data.product_id, "related", "remove", data.product.id);
};

const removeFromSource = (sourceIndex, targetIndex, column) => {
    product_items.value[sourceIndex][column].splice(targetIndex, 1);
};
const addFromSource = (sourceIndex, column, data) => {
    let structure = {};
    structure["id"] = -1;
    structure["product_id"] = product_items.value[sourceIndex].id;
    structure["product"] = data;
    if (column === "Related") {
        structure["related_product_id"] = data.id;
        column = "related_product";
    }
    if (column === "Recommended") {
        structure["recommended_product_id"] = data.id;
        column = "recommended_product";
    }

    product_items.value[sourceIndex][column].push(structure);
};

//!SECTION -> ViewMore Data
const viewMore = ref({
    showDialog: false,
    sourceProduct: null,
    sourceIndex: -1,
    mode: null,
    data: null,
});
const viewMoreOpen = (product, mode, data, index) => {
    viewMore.value.showDialog = true;
    viewMore.value.sourceProduct = product;
    viewMore.value.sourceIndex = index;

    viewMore.value.mode = mode;
    viewMore.value.data = data;
};
const viewMoreClose = () => {
    viewMore.value.showDialog = false;
    viewMore.value.sourceIndex = -1;
    viewMore.value.sourceProduct = null;
    viewMore.value.mode = null;
    viewMore.value.data = null;
};
const viewMoreRemove = async (data) => {
    if (viewMore.value.mode === "Related") {
        addChanges(
            viewMore.value.sourceProduct.id,
            "related",
            "remove",
            data.product.id,
        );
    }
    if (viewMore.value.mode === "Recommended") {
        addChanges(
            viewMore.value.sourceProduct.id,
            "recommended",
            "remove",
            data.product.id,
        );
    }
};
</script>
