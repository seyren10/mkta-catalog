<template>
        <div >
                <div class="px-4 sm:px-0">
                        <h3 class="text-base font-semibold leading-7 text-gray-900">Hotlinks</h3>
                </div>
                <div class="
                        grid 
                        grid-flow-row 
                        grid-cols-12 
                        max-h-[11rem] 
                        overflow-auto 
                        gap-1 
                        auto-rows-max
                        ">
                        <button class="
                                        gap-2 
                                        rounded-md 
                                        p-2 
                                        col-span-12
                                        sm:col-span-6
                                        md:col-span-4
                                        lg:col-span-3
                                        grid
                                "
                                :class="' text-center'"
                                v-for="item in hotlinks"
                                :key="item.title">
                                <v-icon
                                        v-if="item.icon"
                                        :name="item.icon"
                                        scale="2"
                                        :class="'mx-auto'"
                                />
                                <span>
                                        {{ item.title }}
                                </span>
                        </button>
                </div>
        </div>
</template>
<script setup>
import { ref, watch, inject, computed } from "vue";

const user = inject("user");
const titleClass  = "text-wrap";
const hotlinks = [
    {
        title: "Product Management",
        icon: "pr-globe",
    },
    {
        title: "Product Management",
        icon: "pr-globe",
    },
    {
        title: "Product Management",
        icon: "pr-globe",
    },
    {
        title: "Product Management",
        icon: "pr-globe",
    },
    {
        title: "Product Management",
        icon: "pr-globe",
    },
    {
        title: "Product Management",
        icon: "pr-globe",
    },
    {
        title: "Product Management",
        icon: "pr-globe",
    },
];
</script>
