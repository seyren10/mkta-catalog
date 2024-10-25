<template>
    <v-card>
        <template #title>
            <p class="text-xl">
                <v-icon name="bi-cart4" class="me-2" scale="1.5"></v-icon>
                Deleted Product Item
            </p>
        </template>
        <div class="grid gap-2">
            <div>
                <v-button
                    @click="getDeletedProducts()"
                    class="ml-auto bg-orange-600 text-white"
                    outlined
                    prepend-inner-icon="md-refresh-sharp"
                >
                    Refresh
                </v-button>
            </div>
            <v-text-field
                prepend-inner-icon="la-search-solid"
                v-model="search"
            />
            <v-data-table
                class="my-2"
                :headers="[
                    {
                        value: 'Product Code',
                        key: 'id',
                        sortable: false,
                    },
                    {
                        value: 'Title',
                        key: 'title',
                        sortable: false,
                    },
                    {
                        value: '',
                        key: 'action',
                        sortable: false,
                    },
                ]"
                :items="products"
                :search="search"
            >
                <template #item.action="{ item }">
                    <div class="max-w-40">
                        <v-button
                            @click="()=>{
                                product_id = item.raw.id
                                isRestoring = true
                            }"
                            class="ml-auto w-full bg-orange-600 text-white"
                            outlined
                            prepend-inner-icon="md-restore-sharp"
                        >
                            Restore
                        </v-button>
                    </div>
                </template>
            </v-data-table>
        </div>
    </v-card>
    <v-dialog
        v-model="isRestoring"
        persistent
        title="Product Item Restore"
        @close="()=>{ isRestoring = false }"
    >
        <div class="min-w-[800px] p-5 grid gap-2">
            <v-text-field
                v-model="confirmText"
                :placeholder="'Confirm Restore ' + product_id "
                :label='"Type \"Confirm Restore "+ product_id +"\" to restore"'
            />
            <div class="ml-auto w-fit">
                <v-button
                    @click="restoreDeletedProducts"
                    :loading="isRestoreLoading"
                    prepend-inner-icon="md-restore-sharp"
                    class="ml-auto w-full border bg-green-500 text-white"
                    >Proceed</v-button
                >
            </div>
        </div>
    </v-dialog>
</template>

<script setup>
import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";
const router = inject("router");
import { useRecycleBinStore } from "@/stores/recycleBinStore";
const recycleBinStore = useRecycleBinStore();

const search = ref("");
const products = ref([]);
const getDeletedProducts = async () => {
    products.value = await recycleBinStore.getDeletedProductItems();
};
await getDeletedProducts();



const isRestoring = ref(false)
const isRestoreLoading = ref(false)
const product_id = ref("");
const confirmText = ref("")
const restoreDeletedProducts = async () => {
    if(!( confirmText.value == ('Confirm Restore ' + product_id.value))){
        isRestoreLoading.value = !true;
        return;
    }
    isRestoreLoading.value = true
    await recycleBinStore.restoreDeletedProductItem(product_id.value)
    isRestoreLoading.value = !true
    await getDeletedProducts();
};
</script>

<style lang="scss" scoped></style>
