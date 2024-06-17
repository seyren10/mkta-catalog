<template>
    <div>
        <v-card
            class="my-2"
            title="Permissions"
            subtitle="List of Permission allowed for the User"
        >
            <v-data-table
                :headers="permission_headers"
                :items="[...user.role_permissions, ...user.permissions]"
            >
                <template #item.title="{ item }">
                    <div class="rounded-lg p-4">
                        <h2 class="text-xl font-bold">
                            {{ item.value }}
                        </h2>
                        <p class="text-gray-600">
                            {{ item.raw.description }}
                        </p>
                    </div>
                </template>
            </v-data-table>
            <v-button
                v-show="isEditing == false"
                @click="isEditing = !isEditing"
                prepend-inner-icon="hi-solid-pencil-alt"
                class="my-2 ml-auto bg-accent text-white"
            >
                Edit Permissions
            </v-button>
        </v-card>
        <hr />
        <v-card
            v-show="isEditing == true"
            class="my-2"
            title="Permissions"
            subtitle="List of Permissions"
        >
            <v-data-table :headers="permission_headers" :items="permissions">
                <template #item.title="{ item }">
                    <div class="grid grid-cols-12 gap-0">
                        <div class="col-span-1 grid place-content-center">
                            <!-- <div class="flex justify-center"> -->
                            <template
                                v-if="
                                    user.role_permissions_keys.includes(
                                        item.raw.key,
                                    )
                                "
                            >
                            </template>
                            <template v-else>
                                <v-icon
                                    v-if="
                                        !user.permissions_keys.includes(
                                            item.raw.key,
                                        )
                                    "
                                    @click="userStore.modifyUserPermissions('append', item.raw.id)"
                                    name="bi-plus-circle-fill"
                                    scale="2"
                                    class="text-green-500"
                                ></v-icon>
                                <v-icon
                                    v-else
                                    @click="userStore.modifyUserPermissions('remove', item.raw.id)"
                                    name="hi-solid-minus-circle"
                                    scale="2"
                                    class="text-red-500"
                                ></v-icon>
                            </template>

                            <!-- </div> -->
                        </div>
                        <div class="col-span-11">
                            <div class="rounded-lg p-4">
                                <h2 class="text-xl font-bold">
                                    {{ item.value }}
                                </h2>
                                <p class="text-gray-600">
                                    {{ item.raw.description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </template>
            </v-data-table>
            <p>
                Note: added permission here will be treated as special
                permission which is directly attached to the user
            </p>
            <v-button
                @click="isEditing = false"
                prepend-inner-icon="hi-solid-pencil-alt"
                class="my-2 ml-auto bg-accent text-white"
            >
                Close Permission Editor
            </v-button>
        </v-card>
    </div>
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

import { usePermissionStore } from "@/stores/permissionStore";
const permissionStore = usePermissionStore();
const { permissions } = storeToRefs(permissionStore);
if (!permissions.length) {
    await permissionStore.getPermissions();
}

const isEditing = ref(false);
const permission_headers = ref([
    {
        value: "id",
        key: "id",
        hidden: true,
        sortable: false,
    },
    {
        value: "Key",
        key: "key",
        hidden: true,
        sortable: false,
    },
    {
        value: "",
        key: "title",
        hidden: false,
        sortable: false,
    },
    {
        value: "Description",
        key: "description",
        hidden: true,
        sortable: false,
    },
]);
</script>
