<template>
    <div>
        <v-alert type="error" v-if="errors"> {{ errors }}</v-alert>
        <form class="space-y-4" @submit.prevent="handleSubmit">
            <VPasswordField
                v-model="form.password"
                prepend-inner-icon="bi-shield"
            ></VPasswordField>
            <VPasswordField
                v-model="form.password_confirmation"
                prepend-inner-icon="bi-shield-check"
            ></VPasswordField>
            <v-button class="bg-accent text-white" :loading="loading"
                >Change Password</v-button
            >
        </form>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useUserStore } from "@/stores/userStore";
import { useAuthStore } from "@/stores/authStore";
import { storeToRefs } from "pinia";
import VPasswordField from "../../components/VPasswordField.vue";

const userStore = useUserStore();
const { errors, loading } = storeToRefs(userStore);

const form = ref({
    password: null,
    password_confirmation: null,
});

async function handleSubmit() {
    await userStore.changePasswordFirstTime(form.value);

    if (!errors.value) await useAuthStore().logout();
}
</script>

<style lang="scss" scoped></style>
