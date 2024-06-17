<template>
    <v-card
        >
        <div class="grid grid-cols-12 gap-2">
            <div
                class="col-span-12 grid min-h-[10rem] grid-cols-1 content-between rounded-lg border p-2 md:col-span-3 lg:col-span-2"
                v-for="area in areas"
            >
                <div>
                    <p class="text-xl">{{ area.title }}</p>
                    <span class="text-gray-400">{{ area.description }}</span>
                </div>
                <div class="text-white">
                    <v-button
                        class="mt-auto w-full bg-red-500"
                        v-if="
                            customer.user_areas
                                .map((obj) => obj['id'])
                                .includes(area.id)
                        "
                        @click="
                            () => {
                                customerStore.modifyCustomerAreas(
                                    'remove',
                                    area.id,
                                );
                                customerStore.getCustomer(id);
                            }
                        "
                        >Remove</v-button
                    >
                    <v-button
                        class="mt-auto w-full bg-green-500"
                        @click="
                            () => {
                                customerStore.modifyCustomerAreas(
                                    'append',
                                    area.id,
                                );
                                customerStore.getCustomer(id);
                            }
                        "
                        v-else
                        >Append</v-button
                    >
                </div>
            </div>
        </div>
    </v-card>
</template>
<script setup>
import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";

const emit = defineEmits(["update"]);
const props = defineProps({
    id: String,
});

import { useCustomerStore } from "@/stores/customerStore";
const customerStore = useCustomerStore();
const { customer, form } = storeToRefs(customerStore);
if (!customer.length) {
    await customerStore.getCustomer(props.id);
}

import { useAreaStore } from "@/stores/areaStore";
const areaStore = useAreaStore();
const { areas } = storeToRefs(areaStore);
if (!areas.length) {
    await areaStore.getAreas();
}
</script>
