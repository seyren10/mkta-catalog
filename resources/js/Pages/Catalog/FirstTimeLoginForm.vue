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
            <v-checkbox
                label="dont show again"
                v-model="dontShowAgain"
            ></v-checkbox>

            <v-button class="bg-accent text-white" :loading="loading"
                >Change Password</v-button
            >
        </form>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";
import { useUserStore } from "@/stores/userStore";
import { useAuthStore } from "@/stores/authStore";
import { storeToRefs } from "pinia";
import VPasswordField from "../../components/VPasswordField.vue";

const userStore = useUserStore();
const { errors, loading } = storeToRefs(userStore);
const emit = defineEmits(["dontShowAgain"]);

const form = ref({
    password: null,
    password_confirmation: null,
});
const dontShowAgain = ref(
    localStorage.getItem("showFirstTimeLogin") === "true" ?? false,
);

async function handleSubmit() {
    await userStore.changePasswordFirstTime(form);

    if (!errors.value) await useAuthStore().logout();
}

watch(
    dontShowAgain,
    (newVal) => {
        localStorage.setItem("showFirstTimeLogin", newVal);
        emit("dontShowAgain", newVal);
    },
    {
        immediate: true,
    },
);
</script>

<style lang="scss" scoped></style>
