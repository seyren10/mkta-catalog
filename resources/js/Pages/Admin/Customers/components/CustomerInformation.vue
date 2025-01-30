<template>
    <v-card>
        {{ form }}
        <div class="grid grid-cols-12 gap-2">
            <div class="col-span-12">
                <v-text-field
                    label="Name"
                    v-model="form.name"
                    prepend-inner-icon="fa-user-alt"
                    clearable
                />
            </div>
            <div class="col-span-12">
                <v-text-field
                    type="email"
                    prepend-inner-icon="pr-globe"
                    v-model="form.email"
                    label="Email"
                    disabled
                />
            </div>

            <div class="col-span-12">
                <v-select
                    v-model="form.broker_company_id"
                    position="top"
                    itemTitle="title"
                    itemValue="id"
                    hint="Leave it Blank if this Customer is a Direct Customer"
                    persistent-hint
                    label="Client of"
                    :items="
                        [
                            {
                                id: -1,
                                title: 'Direct Client',
                                description: '',
                            },
                        ].concat(companies)
                    "
                />
            </div>
            <div class="col-span-12">
                <v-select
                    label="Status"
                    prepend-inner-icon="fa-user-cog"
                    v-model="form.is_active"
                    :items="[
                        { title: 'Active', value: true },
                        { title: 'Inactive', value: false },
                    ]"
                    itemTitle="title"
                    itemValue="value"
                />
            </div>
            <div class="col-span-12">
                <div class="grid grid-cols-12">
                    <div class="col-span-12 md:col-span-6">
                        <v-button
                            @click="
                                () => {
                                    customerStore.resetPassword(customer.id),
                                        (showPassword = true);
                                }
                            "
                            prepend-inner-icon="ri-key-2-line"
                            class="mt-auto bg-accent text-white"
                            >Reset Password</v-button
                        >
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <v-button
                            @click="()=>{
                                emit('update');
                            }"
                            prepend-inner-icon="md-save-round"
                            class="ml-auto bg-accent text-white"
                            >Update Customer Information</v-button
                        >
                    </div>
                </div>
            </div>
        </div>

        <v-dialog
            v-model="showPassword"
            @close="
                () => {
                    showPassword = false;
                }
            "
            persistent
            title="New Password"
        >
            <div class="min-w-[800px] p-5">
                <p>Password for {{ form.email }}</p>
                <v-heading type="h2">{{ form.password }}</v-heading>
                <div class="ml-auto w-fit">
                    <v-button
                        prepend-inner-icon="md-close-round"
                        outlined
                        @click="
                            () => {
                                showPassword = false;
                            }
                        "
                        class="block rounded-lg bg-accent p-2 text-lg uppercase text-white disabled:bg-gray-500"
                        >close</v-button
                    >
                </div>
            </div>
        </v-dialog>
    </v-card>
</template>
<script setup>
import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";

const emit = defineEmits(["update"]);


const showPassword = ref(false);
const form = inject('form');
const customer = inject('customer');

const customerStore = inject('customerStore');
const companies = inject('companies');



</script>
