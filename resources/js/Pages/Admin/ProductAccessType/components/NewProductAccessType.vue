<template>
    <div class="my-2">
        <div class="pt-2">
            <h2 class="text-xl font-bold">Product Access Types</h2>
            <p class="text-gray-600">If you are not a developer, go away!!!!</p>

            <div class="grid grid-cols-2">
                <div>
                    <v-text-field
                        label="Title"
                        v-model="form.title"
                        @keyup="
                            () => {
                                form.type = form.title
                                    .trim()
                                    .toLowerCase()
                                    .replace(/ /g, '-');
                            }
                        "
                    />
                    <v-text-field label="Type" v-model="form.type" />
                </div>
                <div>
                    <v-text-field
                        label="Description"
                        v-model="form.description"
                    />

                    <v-select
                        v-model="form.ref_type"
                        itemTitle="text"
                        itemValue="value"
                        label="Reference Type"
                        :items="[
                            { text: 'Direct', value: 'direct' },
                            { text: 'Indirect', value: 'indirect' },
                        ]"
                    />
                </div>
                <div>
                    <h2 class="text-xl font-bold">Reference Table</h2>
                    <p class="text-gray-600">This is a description</p>
                    <div class="mt-2 grid grid-cols-2">
                        <div class="col-span-4 sm:col-span-2">
                            <v-text-field
                                label="Table"
                                v-model="form.ref_table"
                                persistent-hint
                                hint="This should be table in the database"
                            />
                        </div>
                        <div class="col-span-4 sm:col-span-2">
                            <v-text-field
                                label="Column"
                                v-model="form.ref_column"
                                persistent-hint
                                :hint="
                                    'This should be a column in the ' +
                                    form.ref_table +
                                    ' table'
                                "
                            />
                        </div>
                    </div>
                </div>
                <div>
                    <h2 class="text-xl font-bold">Source Table</h2>
                    <p class="text-gray-600">This is a description</p>
                    <div class="mt-2 grid grid-cols-2">
                        <div class="col-span-4 sm:col-span-2">
                            <v-text-field
                                label="Table"
                                v-model="form.source_table"
                                persistent-hint
                                hint="This should be table in the database"
                            />
                        </div>
                        <div class="col-span-4 sm:col-span-2">
                            <v-text-field
                                label="Column"
                                v-model="form.source_column"
                                persistent-hint
                                :hint="
                                    'This should be a column in the ' +
                                    form.source_table +
                                    ' table'
                                "
                            />
                        </div>
                    </div>
                </div>
                <div class="col-span-2">
                    <v-button
                        v-show="!isExist"
                        :loading="loading"
                        prepend-inner-icon="md-save-round"
                        class="ml-auto bg-accent text-white"
                        @click="
                            async () => {
                                
                                await productAccessTypeStore.addProductAccessType();
                                $emit('close');
                            }
                        "
                        >Save Product Access Type</v-button
                    >
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";
const router = inject("router");
const emits = defineEmits(["close"]);

import { useProductAccessTypeStore } from "@/stores/productAccessTypeStore";
const productAccessTypeStore = useProductAccessTypeStore();
const { product_access_types, form, loading, isExist } = storeToRefs(productAccessTypeStore);
if (!product_access_types.length) {
    await productAccessTypeStore.getProductAccessTypes();
}
</script>
