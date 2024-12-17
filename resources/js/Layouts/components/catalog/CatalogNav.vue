<template>
    <nav class="bg-[#04151f]">
        <div class="container pb-2">
            <!-- #region toolbar-header -->
            <div
                class="flex justify-end pt-1 text-[min(1vw_+_.3rem,.7rem)] text-slate-400"
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
            <!-- #endregion toolbar-header -->

            <!-- #region mobile-user-avatar -->
            <!-- <div
                
                class="ml-auto flex w-fit cursor-pointer items-center gap-2 py-2 md:hidden"
            >
            sa
                <span class="text-slate-200 underline">{{ user?.name }}ss</span>
                <img
                    src="/mk-images/hero-images/3.png"
                    alt="profile"
                    class="max-w-5 rounded-full bg-white ring ring-slate-700"
                />
            </div> -->
            <!-- #endregion mobile-user-avatar -->

            <div class="mt-3 flex items-center justify-between gap-5">
                <!-- #region mk-logo -->

                <img
                    src="/MKLogo-White.svg"
                    alt=""
                    class="xs:block max-w-[min(1vw+4rem,_7rem)] cursor-pointer lg:hidden"
                    @click="$router.push({ name: 'catalog' })"
                />
                <img
                    src="/Logo.png"
                    alt=""
                    class="hidden max-w-[10rem] cursor-pointer lg:block"
                    @click="$router.push({ name: 'catalog' })"
                />
                <!-- #endregion mk-logo -->

                <!-- #region searchbar -->
                <div class="inline-flex grow items-center gap-2 sm:grow-0">
                    <!-- #region Categories -->

                    <button @click="(e) => (menu = e.currentTarget)">
                        <div class="px-2">
                            <v-icon
                                name="pr-bars"
                                scale="1.5"
                                class="fill-accent"
                            ></v-icon>
                        </div>
                    </button>
                    <v-menu class="p-3" v-model="menu" center>
                        <template #default="{ loaded }">
                            <div
                                class="scrollbar max-h-[70vh] max-w-[80rem] overflow-y-auto overscroll-contain bg-[#04151f] p-5"
                            >
                                <div class="mb-8">
                                    <h1
                                        class="mb-2 text-lg tracking-wide text-accent"
                                    >
                                        All Categories
                                    </h1>
                                    <p class="text-[.85rem] text-slate-400">
                                        Explore our massive amount of fiberglass
                                        and inlitefi products.
                                    </p>
                                </div>
                                <div
                                    class="grid gap-x-3 gap-y-5 md:grid-cols-3 lg:grid-cols-5"
                                    @click="menu = null"
                                >
                                    <div
                                        v-for="category in categories"
                                        :key="category.id"
                                    >
                                        <router-link
                                            :to="{
                                                name: 'categories',
                                                params: { id: category.id },
                                            }"
                                        >
                                            <v-text-on-image
                                                :image="
                                                    s3Thumbnail(category.img)
                                                "
                                                :title="category.title"
                                                no-overlay
                                                class="aspect-[16/9]"
                                            >
                                                <!-- <template #overlay="data">
                                                    <div
                                                        class="absolute left-0 top-0 bg-black bg-opacity-25 px-2 py-1 text-[.7rem] text-white [border-bottom-right-radius:0.5rem]"
                                                    >
                                                        {{ data.title }}
                                                    </div>
                                                </template> -->
                                            </v-text-on-image>
                                        </router-link>
                                        <!-- <ul
                                            class="flex max-h-[15rem] cursor-pointer flex-col flex-wrap gap-3 pl-1 pt-2 text-[.8rem] text-slate-400 md:max-h-fit md:flex-nowrap"
                                        >
                                            <li
                                                v-for="child in category.sub_categories"
                                                class="group flex items-center overflow-hidden duration-200 hover:text-accent"
                                            >
                                                <v-icon
                                                    class="w-0 duration-200 group-hover:w-5"
                                                    name="md-keyboardarrowright-round"
                                                ></v-icon>
                                                <router-link
                                                    :to="{
                                                        name: 'categories',
                                                        params: {
                                                            id: category.id,
                                                        },
                                                        query: {
                                                            sub: child.id,
                                                        },
                                                    }"
                                                    >{{
                                                        child.title
                                                    }}</router-link
                                                >
                                            </li>
                                        </ul> -->
                                    </div>
                                </div>
                            </div>
                        </template>
                    </v-menu>

                    <!-- #endregion Categories -->

                    <div
                        class="flex grow overflow-hidden rounded-lg bg-white duration-500 has-[:focus]:ring-4 has-[:focus]:ring-accent sm:w-[max(35vw_+_1rem,_15rem)]"
                    >
                        <div class="my-auto grow pt-1">
                            <textarea
                                class="w-full resize-none px-4 text-primary outline-none"
                                rows="1"
                                placeholder="Search for products"
                                v-model="search"
                                @keydown.enter.prevent="handleSearch"
                            />
                        </div>
                        <v-button
                            class="!rounded-none bg-accent text-white"
                            @click="handleSearch"
                        >
                            <div class="px-2">
                                <v-icon
                                    name="la-search-solid"
                                    scale="1"
                                ></v-icon>
                            </div>
                        </v-button>
                    </div>

                    <Wishlist max-width="800"> </Wishlist>
                </div>
                <!-- #endregion searchbar -->

                <!-- #region user-avatar -->
                <div class="flex cursor-pointer items-center gap-2">
                    <span class="underline">{{ user?.name.split(' ').map( (word)=>{ return word[0]; } ).join(' ') }}</span>
                    <router-link :to="{ name: 'profile' }">
                        <v-tooltip activator="parent">Profile</v-tooltip>
                        <img
                            src="/mk-images/hero-images/4.png"
                            alt="profile"
                            class="max-w-10 rounded-full bg-white ring ring-slate-700"
                        />
                    </router-link>
                </div>
                <!-- #endregion user-avatar -->
            </div>
        </div>

        <!-- #region footer -->
        <div
            v-hide-on-scroll:[100]="handleHide"
            class="hidden h-16 overflow-hidden duration-300 lg:block"
        >
            <div
                class="container mt-3 flex items-center justify-center gap-4 py-1"
            >
                <FeatureCategory></FeatureCategory>
            </div>
        </div>
        <!-- #endregion footer -->
    </nav>
</template>

<script setup>
import { inject, ref } from "vue";
import { useCategoryStore } from "@/stores/categoryStore";
import { storeToRefs } from "pinia";
import { useRouter, useRoute } from "vue-router";

import FeatureCategory from "./FeatureCategory.vue";
import Wishlist from "./Wishlist.vue";

//reactives
const route = useRoute();
const router = useRouter();
const categoryStore = useCategoryStore();
const { categories } = storeToRefs(categoryStore);
const menu = ref(false);
const search = ref(route.query.q || "");
const s3Thumbnail = inject("s3Thumbnail");

//non-reactives
const headerData = [
    // { title: "Contact Sales Support", icon: "ri-customer-service-2-line" },
    // { title: "Report a problem", icon: "ri-bug-2-line" },
    // { title: "Asia", icon: "pr-globe" },
];

const handleSearch = () => {
    router.push({ name: "products", query: { q: search.value } });
};

//injects
const user = inject("currentUser");

function handleHide(el, hidden) {
    el.classList.toggle("!h-0", !hidden);
}
</script>

<style lang="scss" scoped></style>
