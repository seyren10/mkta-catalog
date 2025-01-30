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
                <div
                    class="inline-flex grow items-center justify-evenly gap-2 sm:grow-0"
                >
                    <!-- #region Categories -->

                    <button @click="(e) => (menu = e.currentTarget)">
                        <div>
                            <v-icon
                                name="pr-bars"
                                scale="1.5"
                                class="fill-accent"
                            ></v-icon>
                        </div>
                    </button>

                    <!-- #endregion Categories -->

                    <!-- #region SearchBar -->
                    <div
                        class="hidden grow overflow-hidden rounded-lg bg-white duration-500 has-[:focus]:ring-4 has-[:focus]:ring-accent sm:w-[max(35vw_+_1rem,_15rem)] lg:flex"
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
                    <div>
                        <v-button
                            icon="la-search-solid"
                            class="text-accent"
                            @click="
                                showMobileSearchDialog = !showMobileSearchDialog
                            "
                        >
                        </v-button>
                    </div>

                    <!-- #endregion SearchBar -->
                    <router-link :to="{ name: 'wishlist' }">
                        <v-badge v-if="wishlistCount">{{
                            wishlistCount
                        }}</v-badge>
                        <v-tooltip activator="parent">Wishlist</v-tooltip>
                        <v-icon name="la-heart" scale="1.5" class="fill-accent">
                        </v-icon>
                    </router-link>
                </div>
                <!-- #endregion searchbar -->

                <!-- #region user-avatar -->
                <div class="flex cursor-pointer items-center gap-2">
                    <span class="hidden underline lg:inline">{{
                        user?.name
                            .split(" ")
                            .map((word) => {
                                return word[0];
                            })
                            .join(" ")
                    }}</span>
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
            v-hide-on-scroll:[5]="handleHide"
            class="hidden h-16 overflow-hidden duration-300 lg:block"
        >
            <div
                class="container mt-3 flex items-center justify-center gap-4 py-1"
            >
                <FeatureCategory></FeatureCategory>
            </div>
        </div>
        <!-- #endregion footer -->

        <!-- #region overlay -->
        <v-menu class="p-3" v-model="menu" center>
            <template #default="{ loaded }">
                <div
                    class="scrollbar max-h-[70vh] max-w-[80rem] overflow-y-auto overscroll-contain bg-[#04151f] p-5"
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
                        @click="menu = null"
                    >
                        <div v-for="category in categories" :key="category.id">
                            <router-link
                                :to="{
                                    name: 'categories',
                                    params: { id: category.id },
                                }"
                            >
                                <v-text-on-image
                                    :image="s3Thumbnail600x600(category.img)"
                                    :title="category.title"
                                    no-overlay
                                    class="aspect-[10/2] md:aspect-[16/9]"
                                >
                                </v-text-on-image>
                            </router-link>
                        </div>
                    </div>
                </div>
            </template>
        </v-menu>
        <v-dialog v-model="showMobileSearchDialog">
            <template #header> </template>
            <div class="w-screen border p-3">
                <div
                    class="flex grow overflow-hidden rounded-lg bg-white duration-500 has-[:focus]:ring-4 has-[:focus]:ring-accent"
                >
                    <div class="my-auto grow pt-1">
                        <textarea
                            class="w-full resize-none px-4 text-primary outline-none"
                            rows="1"
                            placeholder="Search for products"
                            v-model="search"
                            @keydown.enter.prevent="handleSearch"
                            v-focus
                        />
                    </div>
                    <v-button
                        class="!rounded-none bg-accent text-white"
                        @click="handleSearch"
                    >
                        <div class="px-2">
                            <v-icon name="la-search-solid" scale="1"></v-icon>
                        </div>
                    </v-button>
                </div>
            </div>
        </v-dialog>
        <!-- #endregion overlay -->
    </nav>
</template>

<script setup>
import { inject, ref } from "vue";
import { useCategoryStore } from "@/stores/categoryStore";
import { storeToRefs } from "pinia";
import { useRouter, useRoute } from "vue-router";

import FeatureCategory from "./FeatureCategory.vue";

//reactives
const route = useRoute();
const router = useRouter();
const categoryStore = useCategoryStore();
const { categories } = storeToRefs(categoryStore);
const menu = ref(false);
const search = ref(route.query.q || "");
const s3Thumbnail600x600 = inject("s3Thumbnail600x600");
const showMobileSearchDialog = ref(false);
const wishlistStore = inject("wishlistStore");
const { wishlistCount } = storeToRefs(wishlistStore);

//non-reactives
const headerData = [
    // { title: "Contact Sales Support", icon: "ri-customer-service-2-line" },
    // { title: "Report a problem", icon: "ri-bug-2-line" },
    // { title: "Asia", icon: "pr-globe" },
];

const handleSearch = () => {
    showMobileSearchDialog.value = false; //close the dialog on search on mobile
    router.push({ name: "products", query: { q: search.value } });
};

//injects
const user = inject("currentUser");

function handleHide(el, hidden) {
    el.classList.toggle("!h-0", !hidden);
}
</script>

<style lang="scss" scoped></style>
