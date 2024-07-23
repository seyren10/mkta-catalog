<template>
    <ul>
        <li
            v-for="(item, i) in items"
            :key="i"
            class="aspect-square w-[5rem] overflow-hidden rounded-lg bg-red-500"
            @click="index = i"
        >
            <img :src="item" alt="" class="h-full w-full object-cover" />
        </li>
        
    </ul>
</template>

<script setup>
import { inject } from "vue";

const items = inject("items");
const index = inject("imageIndex");
</script>

<style lang="scss" scoped></style>
