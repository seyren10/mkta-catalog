<template>
    <RouterView v-slot="{ Component }">
        <template v-if="Component">
            <Suspense timeout="0">
                <component :is="Component" />

                <template v-slot:fallback>
                    <!-- <Spinner /> -->
                    <h1>Loading....</h1>
                </template>
            </Suspense>
        </template>
    </RouterView>
</template>

<script setup>
import { storeToRefs } from "pinia";
import { provide } from "vue";
import { RouterView } from "vue-router";
import { useUserStore } from "@/stores/userStore";
import { useCategoryStore } from "@/stores/categoryStore";

const userStore = useUserStore();
const { user } = storeToRefs(userStore);

const categoryStore = useCategoryStore();
provide("user", user);
provide("categoryStore", categoryStore);
</script>
