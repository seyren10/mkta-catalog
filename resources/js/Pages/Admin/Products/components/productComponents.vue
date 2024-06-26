<template>
    <div class="rounded-lg bg-white p-6 shadow-md">
        <h2 class="mb-4 text-gray-800">
            This section displays the components or properties of a Product in
            which is available in the Catalog
        </h2>
        <div class="flex justify-end">
            <v-button
                class="m-3 border"
                prepend-inner-icon="fa-puzzle-piece"
                @click="showNewComponent = true"
                >New Component</v-button
            >
            <v-button
                class="my-2 ml-auto border"
                prepend-inner-icon="md-refresh-sharp"
                @click="refreshComponent()"
                >Refresh</v-button
            >
        </div>
        <div class="grid grid-cols-2 gap-2">
            <template v-for="(component, index) in components">
                <componentsViewer
                    :product_id="id"
                    :data="component"
                    @change="refreshComponent"
                />
            </template>
        </div>
    </div>
    <v-dialog
        title="Product Components"
        v-model="showNewComponent"
        @close="newComponentClose()"
    >
        <div class="min-w-[800px]">
            <newComponent :id="id" @submit="newComponentClose()" />
        </div>
    </v-dialog>
</template>
<script setup>
import { onBeforeMount, ref, watch, inject, computed } from "vue";
import { storeToRefs } from "pinia";

/*SECTION - Components */
import newComponent from "./essentials/newComponent.vue";
/*SECTION - End Components */

/*SECTION - Props */
const props = defineProps({
    id: String,
});
/*SECTION - End Props */

/*SECTION - Variables */
const showNewComponent = ref(false);

/*SECTION - End Variables */

/*SECTION - Product Info */
import { useProductStore } from "@/stores/productStore";
const productStore = useProductStore();
const { product_item } = storeToRefs(productStore);
if (!product_item.length) {
    await productStore.getProductItem(props.id);
}
/*SECTION - End Product Info */
/*SECTION - Product Component */
import { useProductComponentStore } from "@/stores/productComponentStore";
import componentsViewer from "./essentials/componentsViewer.vue";
const productComponentStore = useProductComponentStore();
const { components } = storeToRefs(productComponentStore);
if (!product_item.length) {
    await productComponentStore.getProductComponent(props.id);
}
/*SECTION - End Product Component */
const refreshComponent = async () => {
    await productComponentStore.getProductComponent(props.id);
};

const newComponentClose = async () => {
    showNewComponent.value = false;
    refreshComponent();
};

import editor_html from "./essentials/productComponents/editor_html.vue";
import editor_list from "./essentials/productComponents/editor_list.vue";
import editor_download from "./essentials/productComponents/editor_download.vue";
import editor_text from "./essentials/productComponents/editor_text.vue";
import editor_image from "./essentials/productComponents/editor_image.vue";
import editor_album from "./essentials/productComponents/editor_album.vue";
import editor_table from "./essentials/productComponents/editor_table.vue";

const getComponent = (type) => {
    switch (type) {
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
};
</script>
