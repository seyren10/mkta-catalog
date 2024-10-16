<template>
    <div class="rounded-lg bg-white p-6 shadow-md">
        <h2 class="mb-4 text-gray-800">
            This section identifies customers who cannot add the product to
            their Wishlist.
        </h2>
        <div class="">
            <v-button
                @click="refreshProductImage()"
                prepend-inner-icon="md-refresh-sharp"
                class=" bg-accent text-white h-fit ml-auto m-1"
                >Refresh Product Images</v-button
            >
            <v-button
                @click="submit_index_changes()"
                prepend-inner-icon="md-save-round"
                class=" bg-accent text-white ml-auto m-1"
                >Save Change on Product Images</v-button
            >
        </div>
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
                        <li class="flex justify-between p-2">
                            <v-button
                                @click="setThumbnail(image.id)"
                                :class="
                                    '!rounded-full bg-indigo-500 !p-1 text-white ' +
                                    (image.is_thumbnail == 1 ? ' hidden ' : ' ')
                                "
                            >
                                <v-icon
                                    scale="1.5"
                                    name="bi-card-image"
                                ></v-icon>
                            </v-button>
                            <div class="text-center">
                                <v-text-field
                                    class="text-center"
                                    label="Order"
                                    v-model="image.index"
                                    type="number"
                                    step="1"
                                    min="0"
                                    max="9999"
                                ></v-text-field>
                            </div>
                            <v-button
                                @click="deleteProductImage(image.id)"
                                class="!rounded-full bg-red-500 !p-1 text-white"
                            >
                                <v-icon
                                    scale="1.5"
                                    name="fa-trash-alt"
                                ></v-icon>
                            </v-button>
                        </li>
                        <li class="flex justify-items-center">
                            <v-text-on-image
                                class="w-full border-none p-2"
                                title="Thumbnail"
                                :noOverlay="true"
                                :image="s3(image.file.filename)"
                            />
                        </li>
                        <li class="flex justify-between p-2">
                            <v-button
                                @click="arrangeProductImage(image.id, -1)"
                                :class="
                                    '!rounded-full border !p-1 ' +
                                    (index == 0 ? ' hidden ' : '')
                                "
                            >
                                <v-icon
                                    scale="1.5"
                                    name="bi-chevron-left"
                                ></v-icon>
                            </v-button>
                            <v-button
                                class="!rounded-full border !p-1"
                                @click="setThumbnail(image.id)"
                            >
                                <v-icon
                                    scale="1.5"
                                    name="fa-folder-open"
                                ></v-icon>
                            </v-button>
                            <v-button
                                @click="arrangeProductImage(image.id, 1)"
                                :class="
                                    '!rounded-full border !p-1 ' +
                                    (index == productImage.length - 1
                                        ? ' hidden '
                                        : '')
                                "
                            >
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

const s3 = inject("s3");
const product_item = inject("product_item");
const productStore = inject("productStore");

//SECTION - Product Image Store
import { useProductImageStore } from "@/stores/productImagesStore";
const productImagesStore = useProductImageStore();
const { productImage, form } = storeToRefs(productImagesStore);

const refreshProductImage = async () => {
    await productImagesStore.getProductImage(product_item.value.id);
};
if (product_item.value.product_images.length > 0) {
    productImage.value = product_item.value.product_images;
} else {
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
const submit_index_changes = async()=>{
    await productImagesStore.updateProductImages();
    refreshProductImage();
}
const submit_insertProductImage_data = async (data) => {
    data.forEach((element, index) => {
        form.value.product_id = product_item.value.id;
        form.value.file_id = element.id;
        form.value.index = index;
        productImagesStore.insertProductImage();
    });
    close_insertProductImage_data();
};
</script>
