<template>
    <div
        class="flex items-center justify-between p-3 text-[1rem] font-medium text-primary"
    >
        <h3>Recently Viewed</h3>
        <div v-if="recentItems.length">
            <v-tooltip activator="parent">clear recently view items</v-tooltip>
            <v-button class="bg-white" @click="clearRecent">
                <v-icon name="fa-trash-alt"></v-icon>
            </v-button>
        </div>
    </div>
    <ul class="grid gap-2 divide-slate-300">
        <li
            class="flex cursor-pointer gap-3 rounded-lg bg-slate-200 p-2 hover:bg-white"
            v-for="(item, index) in recentItems"
        >
            <router-link
                :to="{ name: 'product', params: { id: item.id } }"
                class="flex items-center gap-3"
            >
                <div class="aspect-square max-w-[5rem] p-1">
                    <v-text-on-image
                        class="h-full"
                        :image="s3(item.thumbnail)"
                        no-overlay
                    ></v-text-on-image>
                </div>
                <div>
                    <p class="line-clamp-2 h-min">{{ item.title }}</p>
                    <span class="text-[.7rem] text-slate-400">{{
                        item.id
                    }}</span>
                </div>
            </router-link>
        </li>
    </ul>
</template>

<script setup>
import { inject, computed, ref } from "vue";

const s3 = inject("s3");
const product = inject("product");

const recentItems = ref([]);
const loadRecent = () => {
    let recent = localStorage.getItem("recent");
    if (recent !== null) {
        recent = JSON.parse(recent);
    } else {
        recent = [];
    }
    recentItems.value = recent.reverse();
};
const clearRecent = () => {
    localStorage.removeItem("recent");
    loadRecent();
};
loadRecent();
</script>

<style lang="scss" scoped></style>
