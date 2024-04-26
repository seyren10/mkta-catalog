<template>
    <nav class="flex items-center justify-between bg-white p-2 shadow md:px-10">
        <div class="w-[5rem]">
            <img src="/Logo.svg" alt="" />
        </div>
        <ul class="hidden flex-wrap justify-center gap-5 md:flex">
            <li
                v-for="link in links"
                :key="link.title"
                class="line-effect relative cursor-pointer"
                :class="{
                    'font-bold before:w-full before:opacity-100':
                        $route.hash === link.to,
                }"
            >
                <a :href="link.to">
                    {{ link.title }}
                </a>
            </li>
        </ul>
        <div class="hidden items-center gap-7 md:flex">
            <button class="font-bold text-primary">Login</button>
            <span class="text-slate-300">|</span>
            <div class="flex gap-3">
                <v-icon name="la-search-solid" scale="1.3"></v-icon>
                <v-icon
                    name="la-heart"
                    scale="1.3"
                    class="fill-accent"
                ></v-icon>
                <v-icon name="la-cog-solid" scale="1.3"></v-icon>
            </div>
        </div>
        <div class="md:hidden">
            <v-icon
                class="cursor-pointer"
                name="la-bars-solid"
                scale="1.3"
                @click="expanded = true"
            ></v-icon>
        </div>

        <!-- Navigation for mobile -->
        <Teleport to="body">
            <div
                v-if="expanded"
                class="fixed right-0 z-20 min-h-[100vh] w-[70%] border-l bg-white p-3"
            >
                <v-icon
                    name="la-times-solid"
                    scale="1.3"
                    class="absolute right-1.5 top-[1.2rem] cursor-pointer"
                    @click="expanded = false"
                ></v-icon>
                <div class="mt-10 grid gap-5">
                    <div>
                        <img src="/Logo.svg" alt="" />
                    </div>
                    <button
                        class="rounded-lg bg-primary p-2 font-bold text-white"
                    >
                        Login
                    </button>

                    <div class="flex justify-evenly gap-3">
                        <v-icon name="la-search-solid" scale="1.3"></v-icon>
                        <v-icon name="la-heart" scale="1.3"></v-icon>
                        <v-icon name="la-cog-solid" scale="1.3"></v-icon>
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
    </nav>
</template>

<script>
import { useMedia } from "@/composables/useMedia";
export default {
    setup() {
        const { isMatched } = useMedia("(min-width: 768px )");

        return {
            isMatched,
        };
    },
    computed: {
        links() {
            return [
                { title: "Home", to: "#home" },
                { title: "Our specialties", to: "#our-specialties" },
                { title: "Work with us", to: "#work-with-us" },
                { title: "Become a partner", to: "#become-a-partner" },
                { title: "About", to: "#about" },
            ];
        },
    },
    data() {
        return {
            expanded: false,
            active: true,
        };
    },
    watch: {
        isMatched(newValue) {
            if (newValue) {
                this.expanded = false;
            }
        },
    },
};
</script>

<style scoped></style>
