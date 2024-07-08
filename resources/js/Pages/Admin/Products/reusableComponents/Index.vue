<template>
    <div>
        <v-text-field prepend-inner-icon="la-search-solid" v-model="search" />
        <div v-show="!allowMultiple" class="my-2 text-xl">Select one only</div>
        <div v-show="allowMultiple && isSelection" class="my-2 text-xl">
            Selected: {{ selectedItemKeys.length }} items
        </div>
        <v-data-table
            class="my-2 border-none"
            :noHeader="true"
            :headers="headers"
            :items="product_items"
            :search="search"
        >
            <template #item.data="{ item }">
                <div class="grid grid-cols-12 gap-2 border py-2">
                    <div class="col-span-1">
                        <div class="flex justify-end">
                            <v-icon
                                :color="
                                    isSelected(item.raw.id) ? 'green' : 'black'
                                "
                                class="ml-auto"
                                scale="2"
                                :name="
                                    isSelected(item.raw.id)
                                        ? 'bi-check-circle-fill'
                                        : 'bi-circle'
                                "
                                @click="
                                    () => {
                                        if (isSelected(item.raw.id)) {
                                            removeItem(item.raw);
                                        } else {
                                            appendItem(item.raw);
                                        }
                                    }
                                "
                            />
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-3 lg:col-span-2">
                        <div class="grid w-full justify-items-center">
                            <v-text-on-image
                                class="h-[150px] max-h-[150px] w-[150px] max-w-[150px] border-none"
                                title="Thumbnail"
                                :noOverlay="true"
                                :image="
                                    s3(
                                        item.raw?.product_thumbnail?.file
                                            ?.filename,
                                    )
                                "
                            />
                            <div>
                                <span class="text-center">{{
                                    item.raw.id
                                }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-8">
                        <pre></pre>
                        <p class="text-xl">{{ item.raw.title }}</p>
                        <span class="text-gray-400">{{
                            item.raw.description
                        }}</span>
                    </div>
                </div>
            </template>
        </v-data-table>
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
import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";

const s3 = inject("s3");

const props = defineProps({
    isSelection: {
        type: Boolean,
        default: true,
    },
    allowMultiple: {
        type: Boolean,
        default: true,
    },
});






import { useProductStore } from "@/stores/productStore";
const productStore = useProductStore();
const { product_items, isValid } = storeToRefs(productStore);

const refresh = async () => {
    await productStore.getProductItems();
};

if (!product_items.length) {
    refresh();
}

const search = ref("");
const headers = ref([
    {
        value: "",
        key: "data",
        hidden: false,
        sortable: false,
    },
]);


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
