<template>
    <div class="my-3">
        <div class="">
            <div class="mt-2 rounded-none border-t-2">
                <v-sheet v-show="currentTab === 'Selection'">
                    <v-card>
                        <template #header>
                            <div class="text-xl font-semibold">
                                <v-icon
                                    scale="2"
                                    name="fa-puzzle-piece"
                                ></v-icon>
                                Component Selection
                            </div>
                        </template>
                        <div class="grid grid-cols-3 gap-2">
                            <template v-for="UI_type in UIs">
                                <v-button
                                    @click="
                                        (form.type = UI_type.type),
                                            (form.value = UI_type.default)
                                    "
                                    :class="
                                        ' h-full !min-h-[100px] w-full border' +
                                        (UI_type.type == form.type
                                            ? ' bg-green-500 text-lg text-white '
                                            : '')
                                    "
                                >
                                    <v-icon
                                        :name="UI_type.icon"
                                        :scale="
                                            UI_type.type == form.type ? 2 : 1
                                        "
                                    ></v-icon>
                                    {{ UI_type.title }}</v-button
                                >
                            </template>
                        </div>
                        <div class="my-2">
                            <v-button
                                @click="
                                    () => {
                                        currentTab = 'Setup';
                                    }
                                "
                                v-show="
                                    !(form.type === null || form.type === '')
                                "
                                class="ml-auto border bg-green-400 text-white disabled:bg-gray-500"
                                prepend-inner-icon="bi-chevron-right"
                                >Next</v-button
                            >
                        </div>
                    </v-card>
                </v-sheet>
                <v-sheet v-show="currentTab === 'Setup'">
                    <v-card>
                        <template #header>
                            <div class="text-lg font-semibold">
                                <v-icon name="la-cog-solid"></v-icon>
                                Component Set-Up
                            </div>
                        </template>
                        <div>
                            <v-text-field
                                class="my-2"
                                v-model="form.title"
                                label="Component Title"
                                hint="Title is visible on top of the Component Card"
                                persistent-hint
                            />
                            <v-checkbox
                                class="my-2"
                                v-model="form.is_visible"
                                label="Show component to Customers"
                            ></v-checkbox>
                            <v-text-field
                                class="my-2"
                                type="number"
                                min="1"
                                max="9999"
                                v-model="form.index"
                            ></v-text-field>
                        </div>
                        <div class="my-2 flex justify-between">
                            <v-button
                                @click="
                                    () => {
                                        currentTab = 'Selection';
                                    }
                                "
                                class="border bg-green-400 text-white"
                                prepend-inner-icon="bi-chevron-left"
                                >Back</v-button
                            >
                            <v-button
                                @click="
                                    () => {
                                        currentTab = 'Content';
                                    }
                                "
                                class="border bg-green-400 text-white"
                                prepend-inner-icon="bi-chevron-right"
                                >Next</v-button
                            >
                        </div>
                    </v-card>
                </v-sheet>
                <v-sheet v-show="currentTab === 'Content'">
                    <v-card>
                        <template #header>
                            <div class="text-lg font-semibold">
                                <v-icon name="hi-database"></v-icon>
                                Component Data
                            </div>
                        </template>
                        <editor_html
                            v-if="form.type === 'html'"
                            :title="form.title"
                            v-model="form.value"
                        />
                        <editor_list
                            v-if="form.type === 'list'"
                            :title="form.title"
                            v-model="form.value"
                        />
                        <editor_download
                            v-if="form.type === 'file'"
                            :title="form.title"
                            v-model="form.value"
                        />
                        <editor_text
                            v-if="form.type === 'text'"
                            :title="form.title"
                            v-model="form.value"
                        />
                        <editor_image
                            v-if="form.type === 'image'"
                            :title="form.title"
                            v-model="form.value"
                        />
                        <editor_album
                            v-if="form.type === 'album'"
                            :title="form.title"
                            v-model="form.value"
                        />
                        <editor_table
                            v-if="form.type === 'table'"
                            :title="form.title"
                            v-model="form.value"
                        />
                        <div class="my-2 flex justify-between">
                            <v-button
                                @click="
                                    () => {
                                        currentTab = 'Setup';
                                    }
                                "
                                class="border bg-green-400 text-white"
                                prepend-inner-icon="bi-chevron-left"
                                >Back</v-button
                            >
                            <v-button
                                @click="
                                    () => {
                                        productComponentStore.addProductComponent(
                                            id,
                                        );
                                        productComponentStore.resetForm();
                                        currentTab = 'Selection';
                                        emit('submit');
                                    }
                                "
                                class="border bg-green-400 text-white"
                                prepend-inner-icon="md-save-round"
                                >Save</v-button
                            >
                        </div>
                    </v-card>
                </v-sheet>
            </div>
        </div>
    </div>
</template>
<script setup>
import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";

import editor_html from "./productComponents/editor_html.vue";
import editor_list from "./productComponents/editor_list.vue";
import editor_download from "./productComponents/editor_download.vue";
import editor_text from "./productComponents/editor_text.vue";
import editor_image from "./productComponents/editor_image.vue";
import editor_album from "./productComponents/editor_album.vue";
import editor_table from "./productComponents/editor_table.vue";

const props = defineProps({
    id: String,
});

const emit = defineEmits(["submit"]);

import { useProductStore } from "@/stores/productStore";
const productStore = useProductStore();
const { product_item, isValid } = storeToRefs(productStore);

if (!product_item.length) {
    await productStore.getProductItem(props.id);
}

const currentTab = ref("Selection");
const UIs = ref([
    {
        type: "html",
        title: "HTML Component",
        icon: "bi-filetype-html",
        default: "",
    },
    {
        type: "list",
        title: "List Component",
        icon: "bi-list-ul",
        default: [{ title: "", value: "" }],
    },
    {
        type: "file",
        title: "File Download Component",
        icon: "fa-download",
        default: { title: "", value: "" },
    },
    {
        type: "text",
        title: "Text Component",
        icon: "bi-text-paragraph",
        default: "",
    },
    {
        type: "image",
        title: "Single Image Component",
        icon: "bi-card-image",
        default: "",
    },
    {
        type: "album",
        title: "Album Component",
        icon: "fa-images",
        default: [],
    },
    {
        type: "table",
        title: "Table Component",
        icon: "bi-table",
        default: {header: [], body: {}, footer: []  },
    },
    
]);

/*SECTION - Product Component */
import { useProductComponentStore } from "@/stores/productComponentStore";
const productComponentStore = useProductComponentStore();
const { form } = storeToRefs(productComponentStore);
/*SECTION - End Product Component */
</script>
