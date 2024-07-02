<template>
    <v-card title="Users" class="my-2 border-0">
        <div>
            <v-heading type="h2">
                <v-icon
                    v-if="$route.meta.redirectTo"
                    @click="
                        () => {
                            router.push({ name: $route.meta.redirectTo });
                        }
                    "
                    name="la-arrow-circle-left-solid"
                    scale="1.8"
                ></v-icon
                >{{ $route.meta.title }}</v-heading
            >
            <p>
                {{ $route.meta.description }}
            </p>
        </div>
    </v-card>
    <v-card class="border-0">
        <template #header>
            <div class="flex">
                <v-button
                    :prepend-inner-icon="tab.icon"
                    @click="selectedTab = tab.key"
                    v-for="tab in [
                        {
                            icon : 'fa-user-alt',
                            title: 'Account Information',
                            key: 'AccountInformation',
                        },
                        {
                            icon : 'ri-lock-password-fill',
                            title: 'Account Security',
                            key: 'AccountSecurity',
                        },
                        {
                            icon : 'gi-checked-shield',
                            title: 'Permissions',
                            key: 'Permissions',
                        },
                    ]"
                    :class="
                        '  ' +
                        (selectedTab == tab.key ? 'bg-accent text-white' : '')
                    "
                >
                    {{ tab.title }}
                </v-button>
            </div>
        </template>
        <AccountInformation v-show="selectedTab === 'AccountInformation'" :id="id" />
        <AccountSecurity v-show="selectedTab === 'AccountSecurity'" :id="id" />
        <AccountPermissions v-show="selectedTab === 'Permissions'" :id="id" />
            
    </v-card>
</template>
<script setup>

import AccountInformation from "./components/AccountInformation.vue";
import AccountPermissions from "./components/AccountPermissions.vue";
import AccountSecurity from "./components/AccountSecurity.vue";

import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";

const props = defineProps({
    id: String,
});

const router = inject("router");

import { useUserStore } from "@/stores/userStore";
const userStore = useUserStore();
const { user, form } = storeToRefs(userStore);
if (!user.length) {
    await userStore.getUser(props.id, {
        includeRoleData: true,
        includePermissions: true,
        includePermissionKeys: true,
        includeRolePermissions: true,
    });
}





const selectedTab = ref("AccountInformation");
</script>

<style lang="scss" scoped></style>
