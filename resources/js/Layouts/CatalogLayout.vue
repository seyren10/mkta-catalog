<template>
    <div class="bg-slate-100 text-sm text-slate-100">
        <header class="fixed top-0 z-[2000] w-full" v-if="user !== null">
            <CatalogNav></CatalogNav>
        </header>

        <main class="mt-[5rem] text-slate-600 lg:mt-[9rem]">
            <RouterView v-slot="{ Component }" :key="$route.path">
                <template v-if="Component">
                    <Suspense timeout="0">
                        <component :is="Component" />

                        <template v-slot:fallback>
                            <Teleport to="#app">
                                <div
                                    class="absolute inset-0 grid place-content-center"
                                >
                                    <VLoader scale="2"></VLoader>
                                </div>
                            </Teleport>
                        </template>
                    </Suspense>
                </template>
            </RouterView>
        </main>

        <v-button
            icon="md-arrowdropup-round"
            class="fixed bottom-[-20%] right-5 z-[2002] rounded-full bg-accent p-1 text-white duration-500"
            v-hide-on-scroll:[500]="handleHide"
            icon-size="1.5"
            @click="handleScrollToTop"
        >
        </v-button>
    </div>
</template>

<script setup>
import { RouterView } from "vue-router";
import { useCategoryStore } from "../stores/categoryStore";
import { storeToRefs } from "pinia";
import { inject } from "vue";

import CatalogNav from "./components/catalog/CatalogNav.vue";
import VLoader from "../components/base_components/VLoader.vue";

const categoryStore = useCategoryStore();
const { categories } = storeToRefs(categoryStore);
const wishlistStore = inject("wishlistStore");
const { wishlists } = storeToRefs(wishlistStore);
const filterStore = inject("filterStore");
const { filters } = storeToRefs(filterStore);

if (!wishlists.value.length) await wishlistStore.getWishlists();

if (!categories.value.length)
    await categoryStore.getCategories({
        includeSubCategories: true,
        includeParentCategory: true,
        includeFile: true,
        includeBannerImage: true,
    });

if (!filters.value.length) await filterStore.getFilters();

const handleHide = (el, hidden) => {
    el.classList.toggle("bottom-[3%]", !hidden);
};

const handleScrollToTop = () => {
    window.scrollTo({ top: 0 });
};

const user = inject("currentUser");
</script>

<style lang="scss" scoped></style>
