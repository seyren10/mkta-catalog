<template>
    <v-card>
        <div class="grid grid-cols-4 gap-2">
            
            <div
                class="
                col-span-4
                md:col-span-2
                lg:col-span-1

                grid 
                grid-cols-2 
                content-between 
                rounded-lg 
                border 
                p-2 
                "
                v-for="company in companies"
            >
                <div>
                    <p class="text-xl">{{ company.title }}</p>
                    <span class="text-gray-400">{{ company.description }}</span>
                </div>
                <div class="text-white mt-auto">
                    <v-button
                        class="w-fit bg-red-500 ml-auto"
                        v-if="
                            customer.user_companies
                                .map((obj) => obj['id'])
                                .includes(company.id)
                        "
                        @click="
                            () => {
                                emit('modify_company','remove', company.id)
                            }
                        "
                        >Remove</v-button
                    >
                    <v-button
                        class="w-fit bg-green-500 ml-auto"
                        @click="
                            () => {
                                emit('modify_company','append', company.id)
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
import {  inject } from "vue";
const emit = defineEmits(["update", "modify_company"]);
const companies = inject('companies');
const customer = inject('customer');
</script>
