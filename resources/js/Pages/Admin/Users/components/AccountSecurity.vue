<template>
    <v-card>
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 h-full md:col-span-6">
                &nbsp;
                <v-button
                    @click="
                        () => {
                            userStore.resetPassword(id), (showPassword = true);
                        }
                    "
                    prepend-inner-icon="ri-key-2-line"
                    class="mt-auto w-full bg-accent text-white"
                    >Reset Password</v-button
                >
                Generate random Alpha-numeric characters
            </div>
            <div class="col-span-12 md:col-span-6">
                <v-text-field
                    :type=" viewPassword ? 'text' : 'password'"
                    prepend-inner-icon="ri-key-2-line"
                    v-model="form.password"
                    label="Password"
                />
                <v-button
                    class=" -mt-5"
                    :prepend-inner-icon="
                        viewPassword ? 'bi-check-circle' : 'bi-circle'
                    "
                    @click="viewPassword = !viewPassword"
                    >{{
                        viewPassword ? "Hide Password" : "Show Password"
                    }}</v-button
                >

                <v-button
                    @click="userStore.changePassword(id)"
                    prepend-inner-icon="md-save-round"
                    class="ml-auto bg-accent text-white"
                    >Update Password</v-button
                >
            </div>
        </div>
        <v-dialog
            v-model="showPassword"
            @close="
                () => {
                    showPassword = false;
                }
            "
            persistent
            title="New User Password"
        >
            <div class="min-w-[800px] p-5">
                <p>Password for {{ form.email }}</p>
                <v-heading type="h2">{{ form.password }}</v-heading>
                <div class="ml-auto w-fit">
                    <v-button
                        prepend-inner-icon="md-close-round"
                        outlined
                        @click="
                            () => {
                                showPassword = false;
                            }
                        "
                        class="block rounded-lg bg-accent p-2 text-lg uppercase text-white disabled:bg-gray-500"
                        >close</v-button
                    >
                </div>
            </div>
        </v-dialog>
    </v-card>
</template>
<script setup>
import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";

const emit = defineEmits(["update"]);
const props = defineProps({
    id: String,
});

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

import { useRoleStore } from "@/stores/roleStore";
const roleStore = useRoleStore();
const { roles } = storeToRefs(roleStore);
if (!roles.length) {
    await roleStore.getRoles();
}

const showPassword = ref(false);
const viewPassword = ref(false);
</script>
