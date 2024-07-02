<template>
    <div
        class="relative grid min-h-screen place-content-center overflow-hidden bg-primary"
    >
        <img
            src="/mk-images/astronaut-photo-op-removebg-preview.png"
            alt="astronaut"
            class="absolute top-0 z-10 rotate-12 opacity-30 mix-blend-color-dodge"
        />
        <img
            src="/mk-images/space-shuttle-photo-op-removebg-preview.png"
            alt="astronaut"
            class="absolute right-0 top-[50%] -rotate-12 opacity-30 mix-blend-color-dodge"
        />
        <div
            class="grid overflow-hidden rounded-lg border border-white bg-white p-5 shadow-xl"
        >
            <div class="p-6">
                <v-heading class="text-center" type="h2">Login</v-heading>
                <p class="text-center text-sm">
                    Please login to view our exciting products and offers.
                </p>

                <form class="mb-20 mt-10 grid gap-3" @submit="handleSubmit">
                    <v-alert type="error" v-if="errors" class="text-sm">
                        {{ errors }}
                    </v-alert>
                    <v-text-field
                        v-model="form.email"
                        label="Email"
                        prepend-inner-icon="co-mail-ru"
                        invalid
                    ></v-text-field>
                    <v-text-field
                        type="password"
                        v-model="form.password"
                        label="Password"
                        prepend-inner-icon="ri-key-2-line"
                    ></v-text-field>
                    <div class="mt-5 flex items-center justify-between pl-1">
                        <div class="flex">
                            <input
                                type="checkbox"
                                v-model="form.remember"
                                id="remember"
                                class="mr-2 accent-accent"
                            />
                            <label for="remember" class="text-sm"
                                >Remember me</label
                            >
                        </div>
                        <a class="text-sm text-primary">Forgot password?</a>
                    </div>
                    <v-button
                        type="submit"
                        class="w-full bg-accent text-white"
                        :loading="loading"
                        >Login</v-button
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
                <router-link :to="{ name: 'catalog' }">catalog</router-link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { storeToRefs } from "pinia";
import { useAuthStore } from "@/stores/authStore";
import { useRouter } from "vue-router";
import { nextTick } from "vue";

//reactives
const emit = defineEmits(["submit"]);
const router = useRouter();

//stores
const authStore = useAuthStore();
const { form, loading, errors } = storeToRefs(authStore);

const handleSubmit = async (e) => {
    e.preventDefault();

    await authStore.login();
};

const scrollToAnchor = () => {
    router.push({ name: "index", hash: "#become-a-partner" });

    nextTick(() => {
        setTimeout(() => {
            const element = document.getElementById("become-a-partner");
            if (element) {
                element.scrollIntoView({ behavior: "smooth", block: "start" });
            }
        }, 1000);
    });
};
</script> 

<style lang="scss" scoped></style>
