<template>
    <div class="grid grid-cols-1 gap-3" v-if="user.first_time_login">
        <v-alert type="error" v-if="errors"> {{ errors.data.message }}</v-alert>

        <form class="space-y-4" @submit.prevent="handleSubmit">
            <VPasswordField v-model="form.password"></VPasswordField>
            <VPasswordField
                v-model="form.password_confirmation"
            ></VPasswordField>

            <v-button class="bg-accent text-white" :loading="loading"
                >Change Password</v-button
            >
        </form>
    </div>
</template>
<script setup>
import { useUserStore } from "@/stores/userStore";
import { useAuthStore } from "@/stores/authStore";
import { storeToRefs } from "pinia";
import { inject, ref } from "vue";

import VPasswordField from "@/components/VPasswordField.vue";

const form = ref({
    password: null,
    password_confirmation: null,
});
const userStore = useUserStore();
const { errors, loading } = storeToRefs(userStore);
const user = inject("currentUser");

async function handleSubmit() {
    await userStore.changePasswordFirstTime(form);

    if (!errors.value) await useAuthStore().logout();
}
</script>
