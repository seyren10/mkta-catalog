<template>
    <ul class="flex gap-3">
        <li
            v-for="(link, index) in links"
            class="capitalize [&:not(:last-of-type)]:after:ml-3 [&:not(:last-of-type)]:after:content-['>']"
            :key="index"
        >
            <router-link
                :key="link.path"
                :to="{ name: link.name }"
                v-if="index !== links.length - 1"
                class="underline-offset-4 hover:underline"
            >
                {{ link.name }}</router-link
            >
            <span v-else class="text-slate-500">{{ link.name }}</span>
        </li>
    </ul>
</template>

<script setup>
import { computed } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const links = computed(() => {
    return route.matched.map((e) => {
        return {
            name: e.name,
            path: e.path,
        };
    });
});

console.log(links.value);
</script>

<style lang="scss" scoped></style>
