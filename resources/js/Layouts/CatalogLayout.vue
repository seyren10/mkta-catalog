<template>
    <div class="text-sm text-slate-100">
        <header>
            <CatalogNav></CatalogNav>
        </header>
        <main>
            <router-view></router-view>
        </main>
    </div>
</template>

<script setup>
import CatalogNav from "./components/CatalogNav.vue";
</script>

<style lang="scss" scoped></style>
