<template>
    <div class="flex min-h-[600px] flex-col gap-y-4">
        <v-text-field
            label="Name"
            v-model="customerStore.form.name"
            prepend-inner-icon="fa-user-alt"
            clearable
        />
        <v-text-field
            type="email"
            prepend-inner-icon="pr-globe"
            v-model="customerStore.form.email"
            label="Email"
            clearable
        />
        <v-text-field
            :type="showPassword ? 'text' : 'password'"
            prepend-inner-icon="ri-key-2-line"
            v-model="customerStore.form.password"
            label="Password"
            clearable
        >
            <template #append-inner>
                <v-button
                    @click="
                        () => {
                            showPassword = !showPassword;
                        }
                    "
                >
                    <v-icon
                        :name="!showPassword ? 'pr-eye' : 'pr-eye-slash'"
                    ></v-icon>
                </v-button>
            </template>
        </v-text-field>
        <v-button
            class="ml-auto border bg-slate-300 text-xs"
            @click="
                () => {
                    customerStore.form.password = generatePassword(10);
                }
            "
            >Generate Password</v-button
        >
        <v-select
            v-model="customerStore.form.broker_company_id"
            position="bottom"
            itemTitle="title"
            itemValue="id"
            hint="Leave it Blank if this Customer is a Direct Customer"
            persistent-hint
            label="Client of"
            :items="[{ id: -1, title: 'Direct Client', description: '' }].concat(companies)"
        />
        <v-select
            v-model="customerStore.form.company_id"
            position="bottom"
            itemTitle="title"
            itemValue="id"
            label="Company"
            :items="companies"
        />
        
        <v-button
            prepend-inner-icon="fa-user-plus"
            outlined
            :disabled="isValid"
            :loading="customerStore.loading"
            @click="saveCustomer"
            class="my-2 ml-auto mt-auto block rounded-lg bg-accent p-2 text-lg text-white disabled:bg-gray-500"
            >Save Customer</v-button
        >
        
    </div>
</template>
<script setup>
import { computed, inject, ref } from "vue";
import { storeToRefs } from "pinia";

const showPassword = ref(false);
const customerStore = inject("customerStore");

const emit = defineEmits(["close"]);

//!SECTION -> Company

import { useCompanyStore } from "@/stores/companyStore";
const companyStore = useCompanyStore();
const { companies } = storeToRefs(companyStore);
await companyStore.getCompanies();

customerStore.form.company_id = companies.value[0].id;

const generatePassword = (charLength) => {
    const lowercaseChars = "abcdefghijklmnopqrstuvwxyz";
    const uppercaseChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    const numberChars = "0123456789";
    const symbolChars = "!@#$%^&*()_+-=[]{}|;:,.<>?";

    let charSet = lowercaseChars;

    let includeUppercase = true;
    let includeNumbers = true;
    let includeSymbols = true;

    if (includeUppercase) charSet += uppercaseChars;
    if (includeNumbers) charSet += numberChars;
    if (includeSymbols) charSet += symbolChars;

    let password = "";
    if (charLength === 0) {
        password = "";
        return;
    }
    for (let i = 0; i < charLength; i++) {
        const randomIndex = Math.floor(Math.random() * charSet.length);
        password += charSet[randomIndex];
    }
    return password;
};
const isValid = computed(() => {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(customerStore.form.email)) {
        return true;
    }
    if (customerStore.form.email.trim().length == 0) {
        return true;
    }
    return customerStore.customers.some((element) => {
        return (
            element.email.trim().toLowerCase() ==
            customerStore.form.email.trim().toLowerCase()
        );
    });
});
const saveCustomer = async () => {
    const res = customerStore.addCustomer();
    emit("close");
};
</script>
