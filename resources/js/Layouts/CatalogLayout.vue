<template>
    <div class="bg-slate-100 text-sm text-slate-100">
        <header class="sticky top-0 z-[2000]">
            <CatalogNav></CatalogNav>
        </header>

        <main class="text-slate-600">
            <router-view></router-view>
        </main>

        <a
            class="fixed bottom-[-20%] right-5 z-[2002] rounded-full bg-accent p-1 text-white duration-500"
            href="#"
            v-hide-on-scroll:[500]="handleHide"
        >
            <v-icon name="md-arrowdropup-round" scale="1.5"></v-icon>
        </a>
    </div>
</template>

<script setup>
import CatalogNav from "./components/catalog/CatalogNav.vue";

const handleHide = (el, hidden) => {
    el.classList.toggle("bottom-[1%]", !hidden);
};
</script>

<style lang="scss" scoped></style>
