<template>
    <div class="grid grid-cols-1 gap-3">
        <v-text-field
            label="Name"
            v-model="currentUser.name"
            prepend-inner-icon="fa-user-alt"
            clearable
        />
        <v-text-field
            type="email"
            prepend-inner-icon="pr-globe"
            v-model="currentUser.email"
            label="Email"
            disabled
        />
        <div class="grid grid-cols-12">
            <div class="col-span-12 md:col-span-6">
                <v-button
                    @click="
                        () => {
                            customerStore.resetPassword(id),
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
                    @click="customerStore.updateCustomer(id)"
                    prepend-inner-icon="md-save-round"
                    class="ml-auto bg-accent text-white"
                    >Update Information</v-button
                >
            </div>
        </div>


        NOT YET DONE
    </div>
</template>
<script setup>
//!SECTION -> Required Init
import { ref } from "vue";
import { storeToRefs } from "pinia";
//!SECTION - Stores
import { useUserStore } from "@/stores/userStore";
const userStore = useUserStore();
const { currentUser, form, loading } = storeToRefs(userStore);




</script>
