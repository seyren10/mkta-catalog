<template>
    <v-card>
        <div class="grid grid-cols-12 gap-2">
            <div
                class="col-span-12 grid min-h-[10rem] grid-cols-1 content-between rounded-lg border p-2 md:col-span-3 lg:col-span-2"
                v-for="company in companies"
            >
                <div>
                    <p class="text-xl">{{ company.title }}</p>
                    <span class="text-gray-400">{{ company.description }}</span>
                </div>
                <div class="text-white">
                    <v-button
                        class="mt-auto w-full bg-red-500"
                        v-if="
                            customer.user_companies
                                .map((obj) => obj['id'])
                                .includes(company.id)
                        "
                        @click="
                            () => {
                                customerStore.modifyCustomerCompanies(
                                    'remove',
                                    company.id,
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
                                customerStore.modifyCustomerCompanies(
                                    'append',
                                    company.id,
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
const { customer } = storeToRefs(customerStore);
if (!customer.length) {
    await customerStore.getCustomer(props.id);
}

import { useCompanyStore } from "@/stores/companyStore";
const companyStore = useCompanyStore();
const { companies } = storeToRefs(companyStore);
await companyStore.getCompanies();
</script>
