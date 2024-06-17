<template>
    <div class="pt-2">
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

        <div class="ml-auto w-fit">
            <v-button
                outlined
                @click="showInsert = true"
                prepend-inner-icon="fa-user-plus"
                class="float-end block rounded-lg bg-accent p-2 text-white"
                >New User</v-button
            >
        </div>
        <div class="py-2">
            <v-text-field
                prepend-inner-icon="la-search-solid"
                v-model="search"
                clearable
            >
            </v-text-field>
            <v-data-table
                class="my-2"
                :headers="headers"
                :items="users"
                :search="search"
                striped
                border
            >
                <template #item.name="{ item }">
                    <h2 class="text-xl font-bold">{{ item.value }}</h2>
                    <p class="text-gray-600">
                        {{ item.raw.email }}
                    </p>
                </template>
                <template #item.role_data="{ item }">
                    {{ item.raw.role_data.title }}
                </template>
                <template #item.action="{ item }">
                    <div class="max-w-40">
                        <v-button
                            v-if="[1].indexOf(item.raw.id) == -1"
                            class="w-full bg-red-600 text-white"
                            @click=""
                            outlined
                            prepend-inner-icon="fa-trash-alt"
                        >
                            Delete
                        </v-button>
                        <!-- <v-button
                            v-if="[1].indexOf(item.raw.id) == -1"
                            class="w-full bg-red-600 text-white"
                            @click=""
                            outlined
                            prepend-inner-icon="fa-user-clock"
                        >
                            Deactivate
                        </v-button> -->
                        <v-button
                            class="w-full bg-accent text-white"
                            @click="
                                () => {
                                    router.push({
                                        name: 'userShow',
                                        params: { id: item.raw.id },
                                    });
                                }
                            "
                            outlined
                            prepend-inner-icon="fa-folder-open"
                        >
                            View
                        </v-button>
                    </div>
                </template>
            </v-data-table>
        </div>
    </div>
    <v-dialog
        v-model="showInsert"
        persistent
        title="New User"
        @close="userStore.resetForm()"
    >
        <div class="min-w-[800px] p-5">
            <div class="">
                <v-text-field
                    label="Name"
                    v-model="form.name"
                    prepend-inner-icon="fa-user-alt"
                    clearable
                />
                <hr class="my-1" width="0%" />
                <v-text-field
                    type="email"
                    prepend-inner-icon="pr-globe"
                    v-model="form.email"
                    label="Email"
                    clearable
                />
                <hr class="my-1" width="0%" />
                <v-select
                    v-model="form.role_id"
                    :items="
                        roles.filter((el) => {
                            return el.id !== 2;
                        })
                    "
                    itemTitle="title"
                    itemValue="id"
                />
            </div>
            <div class="ml-auto w-fit">
                <v-button
                    prepend-inner-icon="fa-user-plus"
                    outlined
                    :loading="loading"
                    v-show="!isExist"
                    @click="
                        () => {
                            showInsert = false;
                            userStore.addUser();
                            showPassword = true;
                        }
                    "
                    class="my-2 block rounded-lg bg-accent p-2 text-lg text-white disabled:bg-gray-500"
                    >Save User</v-button
                >
            </div>
        </div>
    </v-dialog>
    <v-dialog
        v-model="showPassword"
        @close="
            () => {
                showPassword = false;
                showInsert = false;
                userStore.resetForm();
                userStore.getUsers({ includeRoleData: true });
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
                            showInsert = false;
                            userStore.resetForm();
                            userStore.getUsers({ includeRoleData: true });
                        }
                    "
                    class="block rounded-lg bg-accent p-2 text-lg uppercase text-white disabled:bg-gray-500"
                    >close</v-button
                >
            </div>
        </div>
    </v-dialog>
</template>

<script setup>
import { onBeforeMount, ref, watch, inject } from "vue";
import { storeToRefs } from "pinia";

import { useUserStore } from "@/stores/userStore";

const userStore = useUserStore();
const { isExist, users, form, loading, errors } = storeToRefs(userStore);

const router = inject("router");

const search = ref("");
const showInsert = ref(false);
const showPassword = ref(false);

if (!users.length) {
    await userStore.getUsers({ includeRoleData: true });
}

import { useRoleStore } from "@/stores/roleStore";
const roleStore = useRoleStore();
const { roles } = storeToRefs(roleStore);
if (!roles.length) {
    await roleStore.getRoles();
}

const headers = ref([
    {
        value: "id",
        key: "id",
        hidden: true,
        sortable: false,
    },
    {
        value: "Type",
        key: "role_data",
        hidden: false,
        sortable: true,
    },
    {
        value: "Details",
        key: "name",
        hidden: false,
        sortable: true,
    },
    {
        value: "Name",
        key: "email",
        hidden: true,
        sortable: true,
    },
    {
        value: "",
        key: "action",
        hidden: false,
        sortable: false,
    },
]);
</script>

<style lang="scss" scoped></style>
