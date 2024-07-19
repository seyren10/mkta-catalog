<template>
    <div
        class="hover: grid min-h-screen grid-rows-[min-content,1fr] overflow-hidden text-sm transition-[grid-template-columns] duration-300 ease-out"
        :class="{
            'grid-cols-[max(17rem),1fr]': toggleSideBar,
            'grid-cols-[0rem,_1fr]': !toggleSideBar,
        }"
    >
        <!-- SideBar -->
        <div
            class="row-span-2 row-start-1 overflow-hidden border-r border-slate-300"
        >
            <slot name="sidebar"> SideBar </slot>
        </div>

        <!-- Tool Bar -->

        <v-toolbar class="border-b border-slate-300">
            <template #title>
                <v-button
                    @click="toggleSideBar = !toggleSideBar"
                    icon="hi-menu-alt-4"
                    class="mr-3"
                    >qwe</v-button
                >
            </template>
        </v-toolbar>

        <!-- maincontent -->
        <slot />
        <!-- /maincontent -->
    </div>
</template>

<script setup>
import { ref, watch } from "vue";
import { useMedia } from "@/composables/useMedia";

//reactives
const toggleSideBar = ref(true);
const { isMatched } = useMedia("(max-width: 768px )");

watch(isMatched, (newValue) => {
    if (newValue) {
        toggleSideBar.value = false;
    }
});
</script>

<style lang="scss" scoped></style>
