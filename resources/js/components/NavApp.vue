<template>
    <nav class="flex items-center justify-between bg-white p-2 shadow md:px-10">
        <div class="w-[12rem]">
            <img src="/Logo.png" alt="" class="invert" />
        </div>
        <ul class="hidden w-full justify-center gap-5 lg:flex">
            <li
                v-for="link in links"
                :key="link.title"
                class="line-effect relative cursor-pointer text-nowrap text-[min(.5vw+.5rem,1rem)]"
                :class="{
                    'font-bold before:w-full before:opacity-100':
                        $route.hash === link.to,
                }"
            >
                <a :href="link.to">
                    {{ link.title }}
                </a>
            </li>
            <li
                v-if="user"
                class="bg-[#04151f] bg-clip-text text-[min(.5vw+.5rem,1rem)] font-bold text-transparent"
            >
                <router-link :to="{ name: 'catalog' }">Catalog</router-link>
            </li>
        </ul>
        <div class="hidden items-center gap-7 lg:flex">
            <v-button v-if="!user" class="font-bold" @click="dialog = true"
                >Login</v-button
            >

            <span class="text-slate-300">|</span>
            <div class="flex items-center gap-3" v-if="user">
                <div>
                    <NavAppSearch> </NavAppSearch>
                    <v-tooltip activator="parent">Search</v-tooltip>
                </div>
                <div>
                    <v-button
                        icon="la-heart"
                        class="text-accent"
                        @click="$router.push({ name: 'catalog' })"
                    ></v-button>
                    <v-tooltip activator="parent">Catalog</v-tooltip>
                </div>

                <div>
                    <v-tooltip activator="parent">Logout</v-tooltip>

                    <v-button
                        icon="pr-sign-out"
                        @click="logout"
                        :loading="loading"
                    ></v-button>
                </div>
            </div>
            <div v-else>
                <a href="#become-a-partner">
                    <v-icon
                        name="ri-customer-service-2-line"
                        scale="1.3"
                        class="text-slate-500"
                    ></v-icon
                ></a>
            </div>
        </div>

        <!-- navigation toggler -->
        <div class="lg:hidden">
            <v-icon
                class="cursor-pointer"
                name="la-bars-solid"
                scale="1.3"
                @click="expanded = !expanded"
            ></v-icon>
        </div>

        <!-- Navigation for mobile -->
        <Teleport to="#overlay">
            <div
                v-if="expanded"
                class="fixed right-0 z-[999] min-h-[100vh] w-[70%] border-l bg-white p-3"
            >
                <div class="mt-[5rem] grid gap-5">
                    <div>
                        <img src="/Logo.png" alt="" class="invert" />
                    </div>
                    <v-button
                        v-if="!user"
                        class="w-full bg-accent text-white"
                        @click="dialog = true"
                        >Login</v-button
                    >
                    <div
                        v-else
                        class="text-center font-medium underline underline-offset-1"
                    >
                        <span>Welcome Back, </span
                        ><span class="text-accent"> {{ user.name }}!</span>
                    </div>
                    <div class="flex justify-evenly gap-3" v-if="user">
                        <NavAppSearch></NavAppSearch>
                        <v-button
                            icon="la-heart"
                            class="text-accent"
                            @click="$router.push({ name: 'catalog' })"
                        ></v-button>
                        <v-button
                            icon="pr-sign-out"
                            @click="logout"
                            :loading="loading"
                        ></v-button>
                    </div>
                    <ul
                        class="grid justify-center gap-6 text-center font-medium"
                    >
                        <li
                            v-for="link in links"
                            :key="link.title"
                            class="cursor-pointer"
                        >
                            <a :href="link.to">
                                {{ link.title }}
                            </a>
                        </li>
                    </ul>
                    <img
                        src="/mk-images/bear-removebg-preview.png"
                        alt="bear"
                        class="absolute bottom-[-5rem] right-[-5rem] -rotate-45 opacity-40"
                    />
                </div>
            </div>
        </Teleport>

        <!-- Login -->
        <Login v-model="dialog"></Login>
    </nav>
</template>

<script setup>
import { ref, watch, inject, computed } from "vue";
import { useMedia } from "@/composables/useMedia";
import { useAuthStore } from "../stores/authStore";
import { storeToRefs } from "pinia";
import { useRouter } from "vue-router";

import Login from "./Login.vue";
import NavAppSearch from "./NavAppSearch.vue";

//reactives
const { isMatched } = useMedia("(min-width: 768px )");
const expanded = ref(false);
const active = ref(true);
const dialog = ref(false);
const authStore = useAuthStore();
const { loading } = storeToRefs(authStore);
const router = useRouter();
//stores

//derived props
const links = computed(() => {
    return [
        { title: "Home", to: "#home" },
        { title: "Our specialties", to: "#our-specialties" },
        { title: "Our processes", to: "#our-processes" },
        { title: "Work with us", to: "#work-with-us" },
        { title: "About", to: "#about" },
        { title: "Become a partner", to: "#become-a-partner" },
    ];
});

//watchers
watch(isMatched, (newValue) => {
    if (newValue) {
        expanded.value = false;
    }
});

//injects
const user = inject("currentUser");

async function logout() {
    user.value = null;
    await authStore.logout();
}
</script>

<style scoped></style>
