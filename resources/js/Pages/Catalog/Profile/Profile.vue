<template>
    <section class="container mt-10">
        <div class="grid gap-5 md:grid-cols-[auto,_1fr]">
            <ProfileInfo
                class="rounded-lg border bg-white p-6 md:h-[min(65vh+_1rem,_50rem)]"
            ></ProfileInfo>

            <div
                class="grid place-content-center rounded-lg border bg-white p-6"
            >
                <div v-if="user.first_time_login" class="space-y-5">
                    <v-alert type="info" class="text-xs"
                        >Please change your password immediately</v-alert
                    >

                    <FirstTimeLoginForm></FirstTimeLoginForm>
                </div>
                <div class="text-center" v-else>
                    <v-icon
                        name="la-meh-blank"
                        scale="2"
                        class="text-slate-300"
                    ></v-icon>
                    <p>Additional content coming soon...</p>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import ProfileInfo from "./ProfileInfo.vue";
import FirstTimeLoginForm from "../FirstTimeLoginForm.vue";
import { inject } from "vue";

const user = inject("currentUser");
</script>

<style lang="scss" scoped></style>
