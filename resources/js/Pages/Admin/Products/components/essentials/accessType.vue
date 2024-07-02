<template>
    <div class="mb-3 rounded-lg bg-white shadow-md">
        <v-accordion expanded>
            <template #title>
                <div class="flex w-full justify-between align-middle">
                    <h2 class="text-xl font-semibold">
                        {{ access_type_data.title }}
                    </h2>
                    <v-button
                        class="border"
                        prepend-inner-icon="md-refresh-sharp"
                        @click="refresh()"
                        >Refresh</v-button
                    >
                </div>
            </template>

            <div class="grid grid-cols-2 gap-x-2">
                <div>
                    <h2 class="text-xl font-semibold">Restricted</h2>
                    <v-chip-input
                        clearable
                        v-model="restricted_data"
                        :appendable="false"
                        :items="source_data"
                        @remove="
                            (item) => {
                                remove(item, 'restriction');
                            }
                        "
                        @addItem="
                            (item) => {
                                append(item, 'restriction');
                            }
                        "
                    />
                </div>
                <div>
                    <h2 class="text-xl font-semibold">Exempted</h2>
                    <v-chip-input
                        clearable
                        v-model="exempted_data"
                        :appendable="false"
                        :items="source_data"
                        @remove="
                            (item) => {
                                remove(item, 'exemption');
                            }
                        "
                        @addItem="
                            (item) => {
                                append(item, 'exemption');
                            }
                        "
                    />
                    <small>
                        Note: Exemptions will overwrite the restriction.
                    </small>
                </div>
            </div>
        </v-accordion>
    </div>
</template>
<script setup>
import { onBeforeMount, ref, watch, inject, computed } from "vue";
import { storeToRefs } from "pinia";
const props = defineProps({
    access_type_id: Number,
    product_id: String,
});

/*SECTION - Restriction and Exemption */
import { useProductAccessTypeStore } from "@/stores/productAccessTypeStore";
const productAccessTypeStore = useProductAccessTypeStore();
const access_type_data = ref(
    await productAccessTypeStore.returnProductAccessType(props.access_type_id, {
        product_id: props.product_id,
        includeSourceData: true,
        includeRestrictedData: true,
        includeExemptedData: true,
    }),
);
/*SECTION - End Restriction and Exemption */
/*SECTION - Methods */
const refresh = async () => {
    access_type_data.value = await productAccessTypeStore.returnProductAccessType(
        props.access_type_id,
        {
            product_id: props.product_id,
            includeSourceData: true,
            includeRestrictedData: true,
            includeExemptedData: true,
        },
    );
};
const append = async (item, action) => {
    productAccessTypeStore.appendProductAccess(
        action,
        props.product_id,
        props.access_type_id,
        item.id,
    );
    refresh();
};
const remove = async (item, action) => {
    productAccessTypeStore.removeProductAccess(
        action,
        props.product_id,
        props.access_type_id,
        item.id,
    );
    refresh();
};
/*SECTION - End Methods */
/*SECTION - Transforming Data for the v-chips */
const source_data = computed(() => {
    return access_type_data.value.source_data.map((element) => {
        return {
            value: element[access_type_data.value.source_column],
            id: element.id,
        };
    });
});
const restricted_data = computed(() => {
    return access_type_data.value.restricted_data.map((element) => {
        return {
            value: element[access_type_data.value.source_column],
            id: element.id,
        };
    });
});
const exempted_data = computed(() => {
    return access_type_data.value.exempted_data.map((element) => {
        return {
            value: element[access_type_data.value.source_column],
            id: element.id,
        };
    });
});
/*SECTION - End Transforming Data for the v-chips */

</script>
