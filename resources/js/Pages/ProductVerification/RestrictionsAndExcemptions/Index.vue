<script setup>
import { useProductAccessTypeStore } from "@/stores/productAccessTypeStore";
import { storeToRefs } from "pinia";
import { inject, ref } from "vue";

const item = inject("item");
const form = inject("verifyForm");

const { fetch, productAccessTypes, getProductAccess } = useProductAccessType();

if (!productAccessTypes.value.length) await fetch();

function useProductAccessType() {
    const productAccessTypeStore = useProductAccessTypeStore();
    const { product_access_types: productAccessTypes, errors } = storeToRefs(
        productAccessTypeStore,
    );
    const productAccess = ref({});
    form.value["restrictionAndExcemption"] = {};

    async function fetch() {
        await productAccessTypeStore.getProductAccessTypes();

        if (productAccessTypes.value.length) {
            await productAccessTypes.value.forEach(async (accessType) => {
                const data =
                    await productAccessTypeStore.returnProductAccessType(
                        accessType.id,
                        {
                            product_id: item.value.product_id,
                            includeSourceData: true,
                            includeRestrictedData: true,
                            includeExemptedData: true,
                            includeOtherData: true,
                        },
                    );

                if (!errors.value) {
                    productAccess.value[data.id] = data;
                }

                form.value["restrictionAndExcemption"][data.id] = {
                    restricted: [],
                    excempted: [],
                };
            });
        }
    }

    function getProductAccess(accessTypeId) {
        return productAccess.value[accessTypeId]?.source_data.map((source) => {
            return {
                id: source.id,
                value: source[productAccess.value[accessTypeId].source_column],
            };
        });
    }

    return {
        fetch,
        productAccessTypes,
        productAccess,
        getProductAccess,
    };
}
</script>

<template>
    <div class="space-y-4">
        <p class="flex items-center gap-2 text-gray-500">
            <v-icon name="pr-info-circle"></v-icon>
            <span>
                Select the customers, companies, or areas that should not have
                access to this product. You can also specify exceptions for
                certain customers, companies, or areas.
            </span>
        </p>
        <v-accordion
            v-for="accessType in productAccessTypes"
            :key="accessType.id"
            :title="accessType.title"
            :open="accessType.id === 1"
            class="border"
        >
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <p class="mb-2 font-medium">Restricted</p>
                    <v-chip-input
                        v-if="form['restrictionAndExcemption'][accessType.id]"
                        :items="getProductAccess(accessType.id)"
                        v-model="
                            form['restrictionAndExcemption'][accessType.id][
                                'restricted'
                            ]
                        "
                        clearable
                    ></v-chip-input>
                </div>
                <div>
                    <p class="mb-2 font-medium">Excempted</p>
                    <v-chip-input
                        v-if="form['restrictionAndExcemption'][accessType.id]"
                        :items="getProductAccess(accessType.id)"
                        v-model="
                            form['restrictionAndExcemption'][accessType.id][
                                'excempted'
                            ]
                        "
                        clearable
                    ></v-chip-input>
                </div>
            </div>
        </v-accordion>
    </div>
</template>

<style lang="scss" scoped></style>
