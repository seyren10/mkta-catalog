<template>
    <div class="rounded-lg bg-white p-6 shadow-md">
        <h2 class="mb-4 text-gray-800">
            This section identifies customers who cannot add the product to
            their Wishlist.
        </h2>
        <div class="text-gray-700">
            <div class="grid grid-cols-4 gap-2">
                <div
                    v-for="(image, index) in productImage"
                    :class="
                        'rounded-lg ' +
                        (image.is_thumbnail == 1 ? ' !bg-gray-400' : '')
                    "
                >
                    <ul>
                        <li class="p-2 flex justify-between">
                            <v-button
                                
                                @click="setThumbnail(image.id)"
                                :class="'!rounded-full bg-indigo-500 !p-1 text-white ' + ((image.is_thumbnail == 1 ? ' hidden ' : ' '))"
                            >
                                <v-icon
                                    scale="1.5"
                                    name="bi-card-image"
                                ></v-icon>
                            </v-button>
                            <v-button
                                @click="deleteProductImage(image.id)"
                                class="!rounded-full bg-red-500 !p-1 text-white "
                            > 
                                <v-icon
                                    scale="1.5"
                                    name="fa-trash-alt"
                                ></v-icon>
                            </v-button>
                        </li>
                        <li class="flex justify-items-center">
                            <v-text-on-image
                                class="border-none p-2 w-full"
                                title="Thumbnail"
                                :noOverlay="true"
                                :image="
                                    [
                                        '/api/s3-resources',
                                        image.file.filename,
                                    ].join('/')
                                "
                            />
                        </li>
                        <li class="flex justify-between p-2">
                            <v-button
                            @click="arrangeProductImage(image.id, -1)"
                            :class="'!rounded-full border !p-1 ' + ( index == 0 ? ' hidden ' : '') ">
                                <v-icon
                                    scale="1.5"
                                    name="bi-chevron-left"
                                ></v-icon>
                            </v-button>
                            <v-button class="!rounded-full border !p-1">
                                <v-icon
                                    scale="1.5"
                                    name="fa-folder-open"
                                ></v-icon>
                            </v-button>
                            <v-button
                            @click="arrangeProductImage(image.id, 1)"
                            :class="'!rounded-full border !p-1 ' + ( index == productImage.length - 1 ? ' hidden ' : '') ">
                                <v-icon
                                    scale="1.5"
                                    name="bi-chevron-right"
                                ></v-icon>
                            </v-button>
                        </li>
                    </ul>
                </div>
                <div class="flex justify-center rounded-lg border">
                    <v-button
                        @click="open_insertProductImage_data()"
                        class="!rounded-full text-green-500"
                    >
                        <v-icon scale="5" name="bi-plus-circle-fill"></v-icon>
                    </v-button>
                </div>
            </div>
        </div>
        <v-dialog
            v-model="insertProductImage_data.show"
            persistent
            title="Product Image"
            @close="close_insertProductImage_data()"
        >
            <div class="min-w-[800px] p-5">
                <fileIndex
                    @submitSelection="submit_insertProductImage_data"
                    @close="close_insertProductImage_data()"
                    @cancel="close_insertProductImage_data()"
                    :showHeader="false"
                    :isSelection="true"
                    :allowMultiple="!false"
                    :filterType="'image'"
                />
            </div>
        </v-dialog>
    </div>
</template>
<script setup>
//SECTION - required
import { onBeforeMount, ref, watch, inject } from "vue";
import { storeToRefs } from "pinia";

//SECTION - Components

import fileIndex from "../../Files/Index.vue";

/*SECTION - Props */
const props = defineProps({
    id: String,
});

//SECTION - Product Store
import { useProductStore } from "@/stores/productStore";
const productStore = useProductStore();
const { product_item } = storeToRefs(productStore);
const refreshProductData = async () => {
    await productStore.getProductItem(props.id, {
        includeProductCategoriesKey: true,
    });
};
if (!product_item.length) {
    refreshProductData();
}
//SECTION - Product Image Store
import { useProductImageStore } from "@/stores/productImagesStore";
import { IoMagnet } from "oh-vue-icons/icons";
const productImagesStore = useProductImageStore();
const { productImage, form } = storeToRefs(productImagesStore);
const refreshProductImage = async () => {
    await productImagesStore.getProductImage(props.id);
};
if (!productImage.length) {
    refreshProductImage();
}

//SECTION - Variables
//SECTION - Emits
//SECTION - Methods
const setThumbnail = async (id) => {
    await productImagesStore.setThumbnail(id);
    refreshProductImage();
};
const arrangeProductImage = async (id, step) => {
    await productImagesStore.moveProductImage(id, step);
    refreshProductImage();
};

const deleteProductImage = async (id) => {
    await productImagesStore.deleteProductImage(id);
    refreshProductImage();
};

const insertProductImage_data = ref({
    show: false,
    file_id: -1,
});
const reset_insertProductImage_data = () => {
    insertProductImage_data.value.show = false;
    insertProductImage_data.value.file_id = -1;
};
const open_insertProductImage_data = () => {
    insertProductImage_data.value.show = true;
};
const close_insertProductImage_data = () => {
    reset_insertProductImage_data();
    refreshProductImage();
};
const submit_insertProductImage_data = async (data) => {
    data.forEach((element) => {
        form.value.product_id = props.id;
        form.value.file_id = element.id;
        productImagesStore.insertProductImage();
    });
    close_insertProductImage_data();
};
</script>
