<template>
    <div
        class="hover: grid h-screen grid-rows-[min-content,1fr] overflow-hidden text-sm transition-[grid-template-columns] duration-300 ease-out"
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

        <div
            class="flex items-center justify-between border-b border-slate-300 px-3 py-1"
        >
            <v-button
                @click="toggleSideBar = !toggleSideBar"
                icon="hi-menu-alt-4"
                class="mr-3"
                >qwe</v-button
            >
            <component :is="toolbarComponent"></component>
        </div>

        <!-- maincontent -->
        <div class="overflow-auto bg-white">
            <slot />
        </div>
        <!-- /maincontent -->
    </div>
</template>

<script setup>
import { markRaw, provide, ref, watch } from "vue";
import { useMedia } from "@/composables/useMedia";

//reactives
const toggleSideBar = ref(true);
const { isMatched } = useMedia("(max-width: 768px )");

const toolbarComponent = ref(null);

watch(isMatched, (newValue) => {
    if (newValue) {
        toggleSideBar.value = false;
    }
});

function setToolbarComponent(component) {
    toolbarComponent.value = markRaw(component);
}

provide("setToolbarComponent", setToolbarComponent);
</script>

<style lang="scss" scoped></style>
