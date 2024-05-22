<template>
    <div class="bg-slate-100 text-sm text-slate-100">
        <header class="sticky top-0 z-[2000]">
            <CatalogNav></CatalogNav>
        </header>

        <main class="text-slate-600">
            <router-view></router-view>
        </main>
    </div>
</template>

<script setup>
import CatalogNav from "./components/catalog/CatalogNav.vue";
</script>

<style lang="scss" scoped></style>
