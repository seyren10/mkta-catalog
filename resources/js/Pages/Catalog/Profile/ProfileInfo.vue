<template>
    <div
        class="grid grid-rows-[auto,auto,1fr] place-content-start justify-center gap-2"
    >
        <div class="mx-auto max-w-[10rem] overflow-hidden rounded-full">
            <v-text-on-image
                image="/mk-images/pumpkin-removebg-preview.png"
                no-overlay
            ></v-text-on-image>
        </div>
        <ul class="mt-5 grid gap-2">
            <li class="flex flex-col gap-3 justify-start">
                <span class="text-slate-400">Name:</span>
                <span>{{ user.name }}</span>
            </li>
            <li class="flex flex-col gap-3 justify-start">
                <span class="text-slate-400">Email:</span>
                <span>{{ user.email }}</span>
            </li>
            <li class="flex flex-col gap-3 justify-start">
                <span class="text-slate-400">Status:</span>
                <span
                    :class="`${userStatusColor} rounded-lg px-2 py-1 text-xs`"
                    >{{ userStatus }}</span
                >
            </li>
        </ul>
        <ul>
            <li class="flex flex-col gap-3 justify-start">
                <span class="text-slate-400">Areas:</span>
                <span> {{ userAreas }}</span>
            </li>
            <li class="flex flex-col gap-3 justify-start">
                <span class="text-slate-400">Companies:</span>
                <span> {{ userCompanies }}</span>
            </li>
        </ul>
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

const userAreas = computed(() => {
    return user.value.user_areas
        ?.reduce((acc, area) => {
            acc.push(area.title);
            return acc;
        }, [])
        .join(",");
});

const userCompanies = computed(() => {
    return user.value.user_companies
        ?.reduce((acc, comp) => {
            acc.push(comp.title);
            return acc;
        }, [])
        .join(",");
});

const handleLogout = async () => {
    await authStore.logout();
};
</script>

<style lang="scss" scoped></style>
