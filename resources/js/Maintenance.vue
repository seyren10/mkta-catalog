<template>
    <v-dialog v-model="showMaintenance" persistent>
        <template #header>
            <div class="p-4">
                <h3 class="text-lg font-medium">Notice</h3>
            </div>
        </template>
        <div class="p-4">
            Our system is under maintenance. Please check again later.
        </div>
    </v-dialog>
</template>

<script setup>
import { inject, onBeforeUnmount, onMounted, onUnmounted, ref } from "vue";
import { useAuthStore } from "@/stores/authStore";
const showMaintenance = ref(true);
const authStore = useAuthStore();

const router = inject("router");

onMounted(() => {
    document.body.style.overflow = "hidden";

    setTimeout(async () => {
        await authStore.logout(false);

        if (router) {
            router.push({ name: "index" });
        }
    }, 5000);
});

onBeforeUnmount(() => {
    document.body.style.overflow = "auto";
});
</script>

<style lang="scss" scoped></style>
