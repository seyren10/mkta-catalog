<template>
    <v-dialog v-model="dialog" persistent>
        <template #activator>
            <v-button class="font-bold" @click="dialog = true">
                Login
            </v-button>
        </template>
        <template #header>
            <v-button
                icon="md-close-round"
                class="absolute right-1"
                @click="dialog = false"
            ></v-button>
        </template>

        <div class="grid items-center p-5 md:grid-cols-2 md:p-0">
            <div class="hidden md:block">
                <img src="/mk-images/3.png" alt="" />
            </div>
            <div class="p-6">
                <v-heading class="text-center" type="h2">Login</v-heading>
                <p class="text-center text-sm">
                    Please login and explore our catalogs.
                </p>
                <form action="" class="mb-20 mt-10 grid gap-3">
                    <v-text-field
                        v-model="email"
                        label="Email"
                        prepend-inner-icon="co-mail-ru"
                    ></v-text-field>
                    <v-text-field
                        v-model="password"
                        label="Password"
                        prepend-inner-icon="ri-key-2-line"
                    ></v-text-field>
                    <div class="mt-5 flex items-center justify-between pl-1">
                        <div class="flex">
                            <input
                                type="checkbox"
                                id="remember"
                                class="mr-2 accent-accent"
                            />
                            <label for="remember" class="text-sm"
                                >Remember me</label
                            >
                        </div>
                        <a class="text-sm text-primary">Forgot password?</a>
                    </div>
                    <v-button type="button" class="w-full bg-accent text-white"
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
</template>

<script setup>
import { ref } from "vue";

//reactives
const email = ref("");
const password = ref("");
const dialog = ref(false);
</script>

<style lang="scss" scoped></style>
