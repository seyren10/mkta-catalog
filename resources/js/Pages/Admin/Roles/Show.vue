<template>
    <v-card>
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
        <v-text-field
            :disabled="[1, 2].includes(role.id)"
            label="Title"
            v-model="form.title"
        ></v-text-field>
        <v-textarea
            :disabled="[1, 2].includes(role.id)"
            label="Description"
            v-model="form.description"
        ></v-textarea>
        <v-button
            @click="roleStore.updateRole(id)"
            prepend-inner-icon="md-save-round"
            class="my-2 ml-auto rounded-lg bg-accent p-2 text-white disabled:bg-gray-500"
        >
            Save Roles
        </v-button>
    </v-card>
    <v-card
        class="my-2"
        title="Role Permissions"
        subtitle="List of Permission allowed in the role"
    >
        <v-data-table :headers="headers" :items="role.permissions">
            <template #item.title="{ item }">
                <div class="rounded-lg p-4">
                    <h2 class="text-xl font-bold">{{ item.value }}</h2>
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
        <v-data-table :headers="headers" :items="permissions">
            <template #item.title="{ item }">
                <div class="grid grid-cols-12 gap-0">
                    <div class="col-span-1 grid place-content-center">
                        <!-- <div class="flex justify-center"> -->
                        <v-icon
                            @click="
                                roleStore.modifyRolePermissions('append', item.raw.id)
                            "
                            v-if="!role.permissions_keys.includes(item.raw.key)"
                            name="bi-plus-circle-fill"
                            scale="2"
                            class="text-green-500"
                        ></v-icon>
                        <v-icon
                            @click="
                                roleStore.modifyRolePermissions('remove', item.raw.id)
                            "
                            v-else
                            name="hi-solid-minus-circle"
                            scale="2"
                            class="text-red-500"
                        ></v-icon>
                        <!-- </div> -->
                    </div>
                    <div class="col-span-11">
                        <div class="rounded-lg p-4">
                            <h2 class="text-xl font-bold">{{ item.value }}</h2>
                            <p class="text-gray-600">
                                {{ item.raw.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </template>
        </v-data-table>
        <v-button
            @click="isEditing = false"
            prepend-inner-icon="hi-solid-pencil-alt"
            class="my-2 ml-auto bg-accent text-white"
        >
            Close Permission Editor
        </v-button>
    </v-card>
</template>
<script setup>
import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";
import { useRoleStore } from "@/stores/roleStore";
import { usePermissionStore } from "@/stores/permissionStore";

const props = defineProps({
    id: String,
});

const router = inject("router");

const permissionStore = usePermissionStore();
const { permissions } = storeToRefs(permissionStore);

if (!permissions.length) {
    await permissionStore.getPermissions();
}

const roleStore = useRoleStore();
await roleStore.getRole(props.id, {
    includePermissions: true,
    includePermissionKeys: true,
});
const { isExist, role, form, loading, errors } = storeToRefs(roleStore);

const isEditing = ref(false);
const headers = ref([
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

<style lang="scss" scoped></style>
