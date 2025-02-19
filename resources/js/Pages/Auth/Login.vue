<template>
    <div
        class="relative isolate grid min-h-screen place-content-center overflow-hidden bg-primary"
    >
        <img
            src="/mk-images/astronaut-photo-op-removebg-preview.png"
            alt="astronaut"
            class="absolute top-0 -z-10 rotate-12 opacity-30 mix-blend-color-dodge"
        />
        <img
            src="/mk-images/space-shuttle-photo-op-removebg-preview.png"
            alt="astronaut"
            class="absolute right-0 top-[50%] -z-10 -rotate-12 opacity-30 mix-blend-color-dodge"
        />
        <div
            class="grid overflow-hidden rounded-lg border border-white bg-white p-5 shadow-xl"
        >
            <div class="p-6" v-if="!currentUser">
                <v-heading class="text-center" type="h2">Login</v-heading>
                <p class="text-center text-sm">
                    Please login to view our exciting products and offers.
                </p>

                <form class="mb-20 mt-10 grid gap-3" @submit="handleSubmit">
                    <v-alert type="error" v-if="errors" class="text-sm">
                        {{ errors.data.message }}
                    </v-alert>
                    <v-text-field
                        v-model="form.email"
                        label="Email"
                        prepend-inner-icon="co-mail-ru"
                        invalid
                    ></v-text-field>
                    <VPasswordField v-model="form.password"></VPasswordField>
                    <div class="mt-5 flex items-center justify-between pl-1">
                        <div class="flex">
                            <v-checkbox
                                v-model="form.remember"
                                label="Remember me"
                            ></v-checkbox>
                        </div>
                        <a class="text-sm text-primary">Forgot password?</a>
                    </div>
                    <v-button
                        type="submit"
                        class="w-full bg-accent text-white"
                        :loading="loading"
                        >Login</v-button
                    >
                    <v-button
                        type="button"
                        outlined
                        class="w-full"
                        @click="$router.push('/')"
                        >Home</v-button
                    >
                </form>
                <p class="text-center text-sm text-slate-600">
                    Dont have an account?
                    <a
                        @click="scrollToAnchor"
                        class="font-bold underline underline-offset-2"
                    >
                        become our partner</a
                    >
                </p>
            </div>

            <!-- user is already logged in -->
            <div class="space-y-5 p-6" v-else>
                <p>you are already logged in.</p>
                <v-button
                    type="button"
                    class="w-full bg-accent text-white"
                    @click="$router.push('/')"
                    >Home</v-button
                >
            </div>
        </div>
    </div>
</template>

<script setup>
import { storeToRefs } from "pinia";
import { useAuthStore } from "@/stores/authStore";
import { useRouter } from "vue-router";
import { inject, ref } from "vue";
import { useUserStore } from "@/stores/userStore";
import VPasswordField from "@/components/VPasswordField.vue";

//reactives
const emit = defineEmits(["submit"]);
const router = useRouter();
const userStore = useUserStore();
const { currentUser } = storeToRefs(userStore);

//stores
const authStore = useAuthStore();
const { form, loading, errors } = storeToRefs(authStore);

const handleSubmit = async (e) => {
    e.preventDefault();

    await authStore.login();
};

const scrollToAnchor = async () => {
    router.push({ name: "index", hash: "#become-a-partner" });
};

//hooks
userStore.getCurrentUser();
</script>

<style lang="scss" scoped></style>
