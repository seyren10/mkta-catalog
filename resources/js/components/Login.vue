<template>
    <Teleport to="body">
        <v-dialog v-model="dialog" persistent>
            <template #header>
                <v-button
                    icon="md-close-round"
                    class="absolute right-1"
                    @click="dialog = false"
                ></v-button>
            </template>

            <div class="grid items-center p-5 md:grid-cols-2 md:p-0">
                <div class="hidden md:block">
                    <img
                        src="/mk-images/3.png"
                        alt=""
                        class="w-full object-fill"
                    />
                </div>
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
                        <div
                            class="mt-5 flex items-center justify-between pl-1"
                        >
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
                            href="#become-a-partner"
                            @click="dialog = false"
                            class="font-bold underline underline-offset-2"
                        >
                            become our partner</a
                        >
                    </p>
                </div>
            </div>
        </v-dialog>
    </Teleport>
</template>

<script setup>
import { storeToRefs } from "pinia";
import { useAuthStore } from "../stores/authStore";

//reactives
const emit = defineEmits(["submit"]);
const dialog = defineModel(false);

//stores
const authStore = useAuthStore();
const { form, loading, errors } = storeToRefs(authStore);

const handleSubmit = (e) => {
    e.preventDefault();

    emit("submit");
};
</script>

<style lang="scss" scoped></style>
