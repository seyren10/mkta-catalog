<template>
    <div class="grid grid-rows-[auto,auto,1fr] place-content-start justify-center gap-6">
        <div class="mx-auto max-w-[10rem] overflow-hidden rounded-full">
            <v-text-on-image
                image="/mk-images/pumpkin-removebg-preview.png"
                no-overlay
            ></v-text-on-image>
        </div>

        <ul class="mt-5 grid gap-2">
            <li class="flex items-center gap-3">
                <span class="text-slate-400">name:</span>
                <span>{{ user.name }}</span>
            </li>
            <li class="flex items-center gap-3">
                <span class="text-slate-400">email:</span>
                <span>{{ user.email }}</span>
            </li>
            <li class="flex items-center gap-3">
                <span class="text-slate-400">status:</span>
                <span
                    :class="`${userStatusColor} rounded-lg px-2 py-1 text-xs`"
                    >{{ userStatus }}</span
                >
            </li>
        </ul>

        <div class="mt-auto">
            <v-button
                append-inner-icon="pr-sign-out"
                icon-size="1"
                outlined
                class="w-full"
                :loading="loading"
                @click="handleLogout"
                >Logout</v-button
            >
        </div>
    </div>
</template>

<script setup>
import { computed, inject } from "vue";
import { useAuthStore } from "@/stores/authStore";
import { storeToRefs } from "pinia";
import { useRouter } from "vue-router";

const user = inject("currentUser");
const authStore = useAuthStore();
const { loading } = storeToRefs(authStore);
const router = useRouter();

const userStatus = computed(() => {
    return user.value.is_active ? "Active" : "Deactivated";
});
const userStatusColor = computed(() => {
    if (userStatus.value === "Active") {
        return "bg-green-200 text-green-500";
    } else return "bg-red-200 text-red-500";
});

async function handleLogout() {
    await authStore.logout();
    await router.push({ name: "login" });
}
</script>

<style lang="scss" scoped></style>
