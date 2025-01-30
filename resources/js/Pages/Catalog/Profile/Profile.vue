<template>
    <section class="container mt-10 p-0">
        <div class="grid grid-cols-1 gap-5 lg:grid-cols-[20rem,auto]">
            <div>
                <div class="rounded-lg border bg-white p-6">
                    <ProfileInfo />
                    <div class="mt-6 grid gap-2">
                        <v-button
                            v-for="page in Pages"
                            :prepend-inner-icon="page.icon"
                            icon-size="1"
                            outlined
                            @click="currentPage = page"
                            :class="
                                'h-full w-full hover:bg-slate-600 hover:text-white ' +
                                (page.key == currentPage.key
                                    ? ' bg-slate-600 text-white '
                                    : '')
                            "
                            :loading="loading"
                            >{{ page.text }}</v-button
                        >
                    </div>
                </div>

                <div class="mt-auto pt-2">
                    <v-button
                        prepend-inner-icon="pr-sign-out"
                        icon-size="1"
                        outlined
                        class="col-span-1 w-full bg-white hover:bg-slate-600 hover:text-white"
                        :loading="loading"
                        @click="handleLogout"
                        >Logout</v-button
                    >
                </div>
            </div>

            <div class="grid rounded-lg border bg-white">
                <v-card>
                    <template #title>
                        <div>
                            <h2 class="text-xl">
                                <v-icon
                                    scale="2"
                                    :name="currentPage.icon"
                                    class="me-2"
                                ></v-icon
                                >{{ currentPage.text }}
                            </h2>
                        </div>
                    </template>
                    <component :is="setPage()" />
                </v-card>
            </div>
        </div>
    </section>
</template>

<script setup>
//!SECTION -> Components
import ProfileInfo from "./ProfileInfo.vue";

import ProfileForm from "./components/ProfileForm.vue";
import Notifications from "./components/Notifications.vue";
import Wishlist from "./components/Wishlist.vue";

//!SECTION -> Required Init
import { ref, shallowRef } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();

import { storeToRefs } from "pinia";
//!SECTION - Stores

import { useAuthStore } from "@/stores/authStore";

const authStore = useAuthStore();
const { loading } = storeToRefs(authStore);

//!SECTION -> Functions
const handleLogout = async () => {
    await authStore.logout();
};

const currentPage = shallowRef({
    icon: "bi-bell",
    text: "Notifications",
    key: "Notifications",
});
const Pages = ref([
    {
        icon: "fa-user-cog",
        text: "Profile",
        key: "Profile",
    },
    {
        icon: "bi-bell",
        text: "Notifications",
        key: "Notifications",
    },
]);
const setPage = () => {
    switch (currentPage.value.key) {
        case "Profile":
            return ProfileForm;
            break;
        case "Notifications":
            return Notifications;
            break;
    }
};

//!SECTION ->
</script>

<style lang="scss" scoped></style>
