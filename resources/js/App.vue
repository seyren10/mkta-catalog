<template>
    <router-view v-slot="{ Component }">
        <template v-if="Component">
            <Suspense timeout="0">
                <component :is="Component" />

                <template v-slot:fallback>
                    <!-- <Spinner /> -->
                    <h1>Loading....</h1>
                </template>
            </Suspense>
        </template>
    </router-view>
</template>

<script setup>
import { useUserStore } from "@/stores/userStore";
import { storeToRefs } from "pinia";
import { provide } from "vue";

const userStore = useUserStore();
const { user } = storeToRefs(userStore);

provide("user", user);
</script>
