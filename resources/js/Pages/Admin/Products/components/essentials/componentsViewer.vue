<template>
    <div class="">
        <v-card class="h-full">
            <template #header>
                <div class="flex justify-between">
                    <div class="text-lg font-semibold">
                        <v-icon name="la-cog-solid"></v-icon>
                        Component Properties : {{ data.type }}
                    </div>
                    <v-button
                        class="!rounded-full bg-red-500 !p-1 text-white"
                        @click="deleteComponent"
                    >
                        <v-icon name="md-close-round"></v-icon>
                    </v-button>
                </div>
            </template>
            <div>
                <v-text-field
                    class="my-2"
                    v-model="data.title"
                    label="Component Title"
                    hint="Title is visible on top of the Component Card"
                    persistent-hint
                />
                <v-checkbox
                    v-model="data.is_visible"
                    value="true"
                    class="my-2"
                    label="Show component to Customers"
                ></v-checkbox>
                <v-text-field
                    v-model="data.index"
                    class="my-2"
                    type="number"
                    min="1"
                    max="9999"
                ></v-text-field>
            </div>
            <div class="my-2 flex justify-between align-middle">
                <v-checkbox v-model="showPreview" label="Show Preview" />
                <v-button
                    @click="updateComponent"
                    class="border bg-green-400 text-white"
                    prepend-inner-icon="md-save-round"
                    >Update Component</v-button
                >
            </div>
            <hr class="mb-2" />
            <component
                class="w-full"
                :showPreview="showPreview"
                :is="componentType"
                v-model="value"
                :title="data.title"
            />
        </v-card>
    </div>
</template>
<script setup>
import { computed, ref } from "vue";
const emit = defineEmits(["change"]);
const props = defineProps({
    product_id: {
        type: String,
        default: "",
    },
    data: {
        type: Object,
        default: {
            id: 1,
            type: "",
            is_visible: 0,
            index: 0,
            title: "",
            value: [],
            product_id: null,
        },
    },
});

const showPreview = ref(false);
const value = ref(null);
//ANCHOR - Component
import editor_html from "./productComponents/editor_html.vue";
import editor_list from "./productComponents/editor_list.vue";
import editor_download from "./productComponents/editor_download.vue";
import editor_text from "./productComponents/editor_text.vue";
import editor_image from "./productComponents/editor_image.vue";
import editor_album from "./productComponents/editor_album.vue";
import editor_table from "./productComponents/editor_table.vue";

switch (props.data.type) {
    case "list":
        value.value = JSON.parse(props.data.value);
        break;
    case "file":
        value.value = JSON.parse(props.data.value);
        break;
    case "album":
        value.value = JSON.parse(props.data.value);
        break;
    case "table":
        value.value = JSON.parse(props.data.value);
        break;
    default:
        value.value = props.data.value;
        break;
}
const componentType = computed(() => {
    switch (props.data.type) {
        case "html":
            return editor_html;
            break;
        case "list":
            return editor_list;
            break;
        case "file":
            return editor_download;
            break;
        case "text":
            return editor_text;
            break;
        case "image":
            return editor_image;
            break;
        case "album":
            return editor_album;
            break;
        case "table":
            return editor_table;
            break;
    }
});

//ANCHOR - Store
/*SECTION - Product Component */
import { useProductComponentStore } from "@/stores/productComponentStore";
const productComponentStore = useProductComponentStore();
/*SECTION - End Product Component */

/*SECTION - Methods */
const updateComponent = async () => {
    await productComponentStore.updateProductComponent(props.data.id, {
        type: props.data.type,
        is_visible: props.data.is_visible,
        index: props.data.index,
        title: props.data.title,
        value: value.value,
    });
    emit("change");
};
const deleteComponent = async () => {
    await productComponentStore.deleteProductComponent(props.data.id);
    emit("change");
};
/*SECTION - End Methods */
</script>
