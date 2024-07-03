<template>
    <div class="bg-slate-100 text-sm text-slate-100">
        <header class="sticky top-0 z-[2000]">
            <CatalogNav></CatalogNav>
        </header>

        <main class="text-slate-600">
            <RouterView v-slot="{ Component }">
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
import { storeToRefs } from "pinia";
import { inject, onErrorCaptured } from "vue";
import { RouterView, useRouter } from "vue-router";

import CatalogNav from "./components/catalog/CatalogNav.vue";
import VLoader from "../components/base_components/VLoader.vue";

//methods
const handleHide = (el, hidden) => {
    el.classList.toggle("bottom-[1%]", !hidden);
};

const handleScrollToTop = () => {
    window.scrollTo({ top: 0 });
};

const categoryStore = inject("categoryStore");
const { categories } = storeToRefs(categoryStore);
if (!categories.value.length)
    await categoryStore.getCategories({
        includeSubCategories: true,
        includeParentCategory: true,
        includeFile: true,
    });
</script>

<style lang="scss" scoped></style>
