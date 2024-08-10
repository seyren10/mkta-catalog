<template>
    <div>
        <v-text-field
            prepend-inner-icon="la-search-solid"
            @keyup.enter="
                () => {
                    pageNumber = 1;
                    refresh();
                }
            "
            v-model="search"
        />

        <div v-show="!allowMultiple" class="my-2 text-xl">Select one only</div>
        <div v-show="allowMultiple && isSelection" class="my-2 text-xl">
            Selected: {{ selectedItemKeys.length }} items
        </div>
        <div class="grid grid-cols-1 gap-2 md:grid-cols-6">
            <div
                :class="'rounded-lg border p-2 ' + (isSelected(item.id) ? ' border-green-500 border-2' : '')"
                v-for="item in product_items"
                :key="item.id"
                @click="
                    () => {
                        if (isSelected(item.id)) {
                            removeItem(item);
                        } else {
                            appendItem(item);
                        }
                    }
                "
            >
                <smallCard :product="item">
                    <template #prepend>
                        <v-icon
                            :color="isSelected(item.id) ? 'green' : 'black'"
                            class="ml-auto"
                            scale="1.5"
                            :name="
                                isSelected(item.id)
                                    ? 'bi-check-circle-fill'
                                    : 'bi-circle'
                            "
                        />
                    </template>
                </smallCard>
            </div>
        </div>
        <pagination @page-change="handlePageChange" :items="paginationLinks" />
        <div class="my-2 flex justify-between" v-show="isSelection">
            <v-button
                @click="cancel"
                prepend-inner-icon="la-times-solid"
                class="w-full border bg-red-600 font-semibold text-white"
                >Cancel</v-button
            >
            <v-button
                @click="submit"
                prepend-inner-icon="la-check-solid"
                class="w-full rounded-md border bg-green-600 p-2 font-semibold text-white"
                >Submit</v-button
            >
        </div>
    </div>
</template>
<script setup>
import pagination from "@/components/PaginationLinks.vue";
import { useQuery } from "@/composables/useQuery";

import smallCard from "./smallCard_Product.vue";

import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";

const s3 = inject("s3");

const props = defineProps({
    unlistedProducts: {
        type: Array,
        default: [],
    },
    isSelection: {
        type: Boolean,
        default: true,
    },
    allowMultiple: {
        type: Boolean,
        default: true,
    },
});

const headers = ref([
    {
        value: "",
        key: "data",
        hidden: false,
        sortable: false,
    },
]);

import { useProductStore } from "@/stores/productStore";
const productStore = useProductStore();
const { isValid } = storeToRefs(productStore);

const product_items = ref(null);
const paginationLinks = ref(null);
const [page, setPage] = useQuery("page", () => refresh());

const search = ref("");
const pageNumber = ref(1);
const refresh = async () => {
    const res = await productStore.getProductItems(
        {
            q: search.value,
            page: pageNumber.value,
            unlisted: props.unlistedProducts,
        },
        false,
    );
    product_items.value = res.data;
    paginationLinks.value = res.pagination;
};
if (!product_items.length) {
    refresh();
}
const handlePageChange = (page) => {
    pageNumber.value = page.label;
    refresh();
};

//SECTION - Pop Up Variables and Functions

const selectedItems = ref([]);
const selectedItemKeys = ref([]);

const emit = defineEmits(["submitSelection", "close", "cancel"]);
const isSelected = (key) => {
    return selectedItemKeys.value.includes(key);
};
const appendItem = (item) => {
    if (!props.allowMultiple && selectedItemKeys.value.length == 1) {
        return;
    }
    selectedItems.value.push(item);
    selectedItemKeys.value.push(item.id);
};
const removeItem = (item) => {
    let index = selectedItemKeys.value.indexOf(item.id);
    selectedItems.value.splice(index, 1);
    selectedItemKeys.value.splice(index, 1);
};
const submit = () => {
    refresh();
    emit("submitSelection", selectedItems.value);
};
const cancel = () => {
    emit("close");
    emit("cancel");
};
</script>
