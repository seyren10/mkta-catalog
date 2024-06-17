<template>
    <div class="pt-2">
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
    <div class="ml-auto w-fit">
            <v-button
                outlined
                @click="showInsert = true"
                prepend-inner-icon="ai-closed-access"
                class="float-end block rounded-lg bg-accent p-2 text-white"
                >New Product Access Types</v-button
            >
        </div>
    <div class="">
        <v-text-field prepend-inner-icon="la-search-solid" v-model="search" />
        <v-data-table
            class="my-2"
            :headers="headers"
            :items="product_access_types"
            :search="search"
        >
            <template #item.action="{ item }">
                <div class="max-w-40">
                    <v-button
                        class="w-full bg-red-600 text-white"
                        @click="
                            () => {
                                showDelete = true;
                                current_product_access_type = item.raw.id;
                                form.title = item.raw.title;
                                form.description = item.raw.description;
                            }
                        "
                        outlined
                        prepend-inner-icon="fa-trash-alt"
                    >
                        Delete
                    </v-button>
                    <v-button
                        class="w-full bg-accent text-white"
                        @click="() => {
                             router.push({
                                        name: 'productAccessTypeShow',
                                        params: { id: item.raw.id },
                                    });
                        }"
                        outlined
                        prepend-inner-icon="fa-folder-open"
                    >
                        View
                    </v-button>
                </div>
            </template>
            <template #item.title="{ item }">
                <p class="text-xl">{{ item.value }}</p>
                <span class="text-gray-400">{{ item.raw.description }}</span>
            </template>
        </v-data-table>
        <v-dialog
            v-model="showDelete"
            persistent
            title="Product Access Types"
            @close="productAccessTypeStore.resetForm()"
        >
            <div class="min-w-[800px] p-5">
                <div class="">
                    Are you sure you want to delete
                    <span class="rounded-lg bg-black px-2 text-white">{{
                        form.title
                    }}</span>
                    Product Access Types?
                    <br />
                </div>

                <div class="mt-11 flex justify-between">
                    <v-button
                        class="bg-red-500 text-white"
                        @click="
                            () => {
                                productAccessTypeStore.deleteProductAccessType(current_product_access_type);
                                productAccessTypeStore.getProductAccessTypes();
                                showDelete = false;
                            }
                        "
                        >Yes</v-button
                    >
                    <v-button
                        class="bg-green-500 text-white"
                        @click="
                            () => {
                                current_product_access_type = -1;
                                showDelete = false;
                                productAccessTypeStore.resetForm();
                            }
                        "
                        >No</v-button
                    >
                </div>
            </div>
        </v-dialog>

        <v-dialog
            v-model="showInsert"
            persistent
            title="Product Access Types"
            @close="()=>{ productAccessTypeStore.resetForm(), productAccessTypeStore.getProductAccessTypes(), showInsert = false }"
        >
            <div class="min-w-[800px] p-5">
                <NewProductAccessType @close="()=>{ productAccessTypeStore.resetForm(), productAccessTypeStore.getProductAccessTypes() , showInsert = false }" />
            </div>
        </v-dialog>
    </div>
</template>
<script setup>

import NewProductAccessType from "./components/NewProductAccessType.vue";

import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";
const router = inject("router");

import { useProductAccessTypeStore } from "@/stores/productAccessTypeStore";
const productAccessTypeStore = useProductAccessTypeStore();
const { product_access_types, form, loading, errors } = storeToRefs(
    productAccessTypeStore,
);
if (!product_access_types.length) {
    await productAccessTypeStore.getProductAccessTypes();
}

const search = ref("");
const headers = ref([
    {
        value: "id",
        key: "id",
        hidden: true,
        sortable: false,
    },
    {
        value: "Details",
        key: "title",
        hidden: !true,
        sortable: false,
    },
    {
        value: "Description",
        key: "description",
        hidden: true,
        sortable: false,
    },
    {
        value: "",
        key: "action",
        hidden: false,
        sortable: false,
    },
]);
const showInsert = ref(false);
const showDelete = ref(false);
const current_product_access_type = ref(0);
</script>
