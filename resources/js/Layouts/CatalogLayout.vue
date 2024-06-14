<template>
    <div class="bg-slate-100 text-sm text-slate-100">
        <header class="sticky top-0 z-[2000]">
            <CatalogNav></CatalogNav>
        </header>

        <main class="text-slate-600">
            <router-view></router-view>
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
import CatalogNav from "./components/catalog/CatalogNav.vue";

//methods
const handleHide = (el, hidden) => {
    el.classList.toggle("bottom-[1%]", !hidden);
};

const handleScrollToTop = () => {
    window.scrollTo({ top: 0 });
};

//hooks
</script>

<style lang="scss" scoped></style>
