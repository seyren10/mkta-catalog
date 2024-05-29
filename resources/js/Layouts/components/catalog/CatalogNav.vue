<template>
    <nav class="primary-gradient">
        <div class="container">
            <div
                class="hidden justify-end pt-1 text-[min(1vw_+_.3rem,.7rem)] text-slate-400 md:flex"
            >
                <div class="flex items-center">
                    <v-text-icon
                        class="flex gap-3 md:gap-5"
                        density=""
                        :items="headerData"
                        icon-size=".9"
                    ></v-text-icon>
                </div>
            </div>

            <div class="ml-auto flex w-fit items-center gap-2 py-2 md:hidden">
                <span class="cursor-pointer text-slate-200 underline">{{
                    user.name
                }}</span>
                <img
                    src="/mk-images/hero-images/3.png"
                    alt="profile"
                    class="max-w-5 rounded-full bg-white ring ring-slate-700"
                />
            </div>
            <div class="mt-3 flex items-center justify-between gap-5">
                <img
                    src="/MKLogo-White.svg"
                    alt=""
                    class="mr-3 hidden max-w-[6rem] sm:block"
                />

                <div class="inline-flex grow items-center gap-5 sm:grow-0">
                    <div
                        class="flex grow overflow-hidden rounded-lg bg-white duration-500 has-[:focus]:ring-4 has-[:focus]:ring-accent sm:w-[max(35vw_+_1rem,_25rem)]"
                    >
                        <div class="my-auto grow pt-1">
                            <textarea
                                class="w-full resize-none px-4 text-primary outline-none"
                                rows="1"
                                placeholder="Search for products"
                            />
                        </div>
                        <v-button class="!rounded-none bg-accent text-white">
                            <div class="px-2">
                                <v-icon
                                    name="la-search-solid"
                                    scale="1"
                                ></v-icon>
                            </div>
                        </v-button>
                    </div>
                    <div class="cursor-pointer">
                        <v-tooltip>Wishlist</v-tooltip>
                        <v-icon name="la-heart" scale="1.5" class="fill-accent">
                        </v-icon>
                    </div>
                </div>

                <div class="hidden items-center gap-2 md:flex">
                    <span class="cursor-pointer underline">{{
                        user.name
                    }}</span>
                    <img
                        src="/mk-images/hero-images/3.png"
                        alt="profile"
                        class="max-w-10 rounded-full bg-white ring ring-slate-700"
                    />
                </div>
            </div>
        </div>
        <div>
            <div class="container mt-3 flex items-center gap-4 py-1">
                <v-menu class="p-3">
                    <template #activator="props">
                        <v-button
                            v-bind="props"
                            ref="parent"
                            class="text-[.8rem] text-slate-300"
                            append-inner-icon="md-keyboardarrowdown-round"
                            >All Categories</v-button
                        >
                    </template>
                    <div
                        class="scrollbar primary-gradient max-h-[70vh] max-w-[80rem] overflow-y-auto overscroll-contain p-5"
                    >
                        <div class="mb-8">
                            <h1 class="mb-2 text-lg tracking-wide text-accent">
                                All Categories
                            </h1>
                            <p class="text-[.85rem] text-slate-400">
                                Explore our massive amount of fiberglass and
                                inlitefi products.
                            </p>
                        </div>
                        <div
                            class="grid gap-x-3 gap-y-5 md:grid-cols-3 lg:grid-cols-5"
                        >
                            <div
                                v-for="category in categories"
                                :key="category.name"
                            >
                                <div
                                    class="group relative cursor-pointer overflow-hidden rounded-lg"
                                >
                                    <img
                                        :src="category.img"
                                        alt=""
                                        class="aspect-video object-cover brightness-75 duration-300 group-hover:scale-110 group-hover:brightness-100"
                                    />
                                    <h2
                                        class="absolute bottom-2 left-2 font-medium text-white"
                                    >
                                        {{ category.name }}
                                    </h2>
                                </div>
                                <ul
                                    class="flex max-h-[10rem] cursor-pointer flex-col flex-wrap space-y-1 pl-1 pt-2 text-[.8rem] text-slate-400 md:max-h-fit md:flex-nowrap"
                                >
                                    <li
                                        v-for="child in category.subCategories"
                                        class="group flex items-center overflow-hidden duration-200 hover:text-accent"
                                    >
                                        <v-icon
                                            class="w-0 duration-200 group-hover:w-5"
                                            name="md-keyboardarrowright-round"
                                        ></v-icon>
                                        <span>{{ child }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </v-menu>
                <FeatureCategory></FeatureCategory>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { inject, ref } from "vue";
import { useCategoryStore } from "@/stores/categoryStore";
import FeatureCategory from "./FeatureCategory.vue";

//stores
const categoryStore = useCategoryStore();
const categories = categoryStore.categories;

const features = [
    { title: "Holloween" },
    { title: "Christmas" },
    { title: "Archways" },
    { title: "Summer" },
    { title: "Comics" },
    { title: "Cartoons" },
    { title: "Anime" },
    { title: "Dragons" },
    { title: "Nutcrackers" },
    { title: "Dont Blame the Kids" },
];

const headerData = [
    { title: "Contact Sales Support", icon: "ri-customer-service-2-line" },
    { title: "Report a problem", icon: "ri-bug-2-line" },
    { title: "Asia", icon: "pr-globe" },
];

//reactives
const parent = ref(null);

//injects
const user = inject("user");
</script>

<style lang="scss" scoped></style>
