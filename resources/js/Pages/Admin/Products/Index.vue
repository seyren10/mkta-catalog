<template>
    <div class="pt-2">
        <div>
            <v-heading type="h2">
                <v-icon
                    v-if="$route.meta.redirectTo"
                    @click="
                        () => {
                            router.push({ name: $route.meta.redirectTo });
                        }
                    "
                    name="la-arrow-circle-left-solid"
                    scale="1.8"
                ></v-icon
                >{{ $route.meta.title }}</v-heading
            >
            <p>
                {{ $route.meta.description }}
            </p>
        </div>
        <div class="">
            <v-button
                outlined
                prepend-inner-icon="bi-cart4"
                class="ml-auto rounded-lg bg-accent p-2 text-white"
                @click="(showInsert = true), productStore.resetForm()"
                >New Product Item</v-button
            >
        </div>
        <v-text-field prepend-inner-icon="la-search-solid" v-model="search" />
        <v-data-table
            class="my-2"
            :noHeader="true"
            :headers="[
                {
                    value: 'Product Items',
                    key: 'content',
                    hidden: false,
                    sortable: false,
                },
                {
                    value: 'Product Items',
                    key: 'actions',
                    hidden: false,
                    sortable: false,
                },
            ]"
            :striped="true"
            :items="product_items"
            :search="search"
        >
            <template #item.content="{ item }">
                <div class="grid w-full grid-cols-10 gap-x-2">
                    <div class="col-span-10 md:col-span-2">
                        <div class="grid justify-items-center ">
                            <v-text-on-image
                                class="h-[150px] max-h-[150px] max-w-[150px] w-[150px] border"
                                title="Thumbnail"
                                :noOverlay="true"
                                :image="'/fuck'"
                            />
                            <div>
                                <span class="text-center">{{ item.raw.id }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-4 md:col-span-6">
                        <p class="text-xl">{{ item.raw.title }}</p>
                        <span class="text-gray-400">{{
                            item.raw.description
                        }}</span>
                    </div>
                    <div class="col-span-10">
                        <div class=" flex justify-end">
                            <v-button class="bg-accent text-white" @click="()=>{ router.push({name: 'productItemShow', params: {id : item.raw.id}}) }" prepend-inner-icon="fa-folder-open">View Product Item</v-button>
                        </div>
                    </div>
                </div>
            </template>
        </v-data-table>
        <v-dialog
            v-model="showInsert"
            persistent
            title="Product Item"
            @close="
                () => {
                    productStore.resetForm();
                    showInsert = false;
                }
            "
        >
            <div class="min-w-[800px] p-5">
                <productItemForm />
                <div>
                    <v-button
                        v-show="isValid"
                        @click="
                            async () => {
                                await productStore.addProductItem();
                                productStore.resetForm();
                                productStore.getProductItems();
                                showInsert = false;
                            }
                        "
                        prepend-inner-icon="md-save-round"
                        class="ml-auto bg-accent text-white"
                        >Save Product Item</v-button
                    >
                </div>
            </div>
        </v-dialog>
    </div>
</template>

<script setup>
import productItemForm from "./components/productItemForm.vue";

const router = inject("router");


import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";

import { useProductStore } from "@/stores/productStore";
const productStore = useProductStore();
const { product_items, isValid } = storeToRefs(productStore);

const showInsert = ref(false);
const search = ref("");

if (!product_items.length) {
    await productStore.getProductItems();
}
</script>

<style lang="scss" scoped></style>
