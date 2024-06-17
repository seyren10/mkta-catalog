<template>
    <div class="pt-2">
        <v-heading type="h2">Roles </v-heading>
        <p>
            Efficiently manage access control and ensure data security within
            the Catalog.
        </p>
        <div class="ml-auto w-fit">
            <v-button
                outlined
                prepend-inner-icon="fa-user-cog"
                class="float-end block rounded-lg bg-accent p-2 text-white"
                @click="(showInsert = true), roleStore.resetForm()"
                >New Roles</v-button
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
                :headers="[
                    {
                        value: '',
                        key: 'id',
                        hidden: true,
                        sortable: false,
                    },
                    {
                        value: '',
                        key: 'title',
                        hidden: !true,
                        sortable: false,
                    },
                    {
                        value: '',
                        key: 'description',
                        hidden: true,
                        sortable: false,
                    },
                    {
                        value: '',
                        key: 'action',
                        hidden: false,
                        sortable: false,
                    },
                ]"
                :items="roles"
                :search="search"
                striped
                border
            >
                <template #item.action="{ item }">
                    <div class="max-w-40">
                        <v-button
                            v-if="[1, 2].indexOf(item.raw.id) == -1"
                            class="w-full bg-red-600 text-white"
                            @click="
                                () => {
                                    showDelete = true;
                                    current_role = item.raw.id;
                                    form.title = item.raw.title;
                                    form.description = item.raw.description;
                                }
                            "
                            outlined
                            prepend-inner-icon="fa-trash-alt"
                        >
                            Delete
                        </v-button>
                        <v-button
                            class="w-full bg-accent text-white"
                            @click="
                                () => {
                                    form.title = item.raw.title;
                                    form.description = item.raw.description;
                                    router.push({
                                        name: 'roleShow',
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
                <template #item.title="{ item }">
                    <div class="rounded-lg p-4">
                        <h2 class="text-xl font-bold">{{ item.value }}</h2>
                        <p class="text-gray-600">
                            {{ item.raw.description }}
                        </p>
                    </div>
                </template>
            </v-data-table>
        </div>
        <!-- </template> -->
        <v-dialog
            v-model="showInsert"
            persistent
            title="Roles"
            @close="roleStore.resetForm()"
        >
            <div class="min-w-[800px] p-5">
                <div class="">
                    <v-text-field
                        label="Title"
                        v-model="form.title"
                        prepend-inner-icon="px-subtitles"
                        clearable
                    />
                    <hr class="my-1" width="0%" />
                    <v-textarea
                        rows="5"
                        v-model="form.description"
                        label="Description"
                        clearable
                    >
                        <template #prepend-inner>
                            <v-icon
                                name="bi-text-paragraph"
                                class="self-start"
                            ></v-icon>
                        </template>
                    </v-textarea>
                </div>
                <div class="ml-auto w-fit">
                    <v-button
                        prepend-inner-icon="md-save-round"
                        outlined
                        :loading="loading"
                        v-show="!isExist"
                        @click="
                            () => {
                                roleStore.addRole();
                                roleStore.getRoles();
                                roleStore.resetForm();
                                showInsert = false;
                            }
                        "
                        class="my-2 block rounded-lg bg-accent p-2 text-lg text-white disabled:bg-gray-500"
                        >Save Roles</v-button
                    >
                </div>
            </div>
        </v-dialog>
        <v-dialog
            v-model="showDelete"
            persistent
            title="Roles"
            @close="roleStore.resetForm()"
        >
            <div class="min-w-[800px] p-5">
                <div class="">
                    Are you sure you want to delete
                    <span class="rounded-lg bg-black px-2 text-white">{{
                        form.title
                    }}</span>
                    Roles?
                    <br />
                </div>
                <span class="mt-9 text-xs"
                    >Note: Source Code needs to be updated.</span
                >
                <div class="mt-11 flex justify-between">
                    <v-button
                        class="bg-red-500 text-white"
                        @click="
                            () => {
                                roleStore.deleteRole(current_role);
                                roleStore.getRoles();
                                showDelete = false;
                                roleStore.resetForm();
                            }
                        "
                        >Yes</v-button
                    >
                    <v-button
                        class="bg-green-500 text-white"
                        @click="
                            () => {
                                current_role = -1;
                                showDelete = false;
                                roleStore.resetForm();
                            }
                        "
                        >No</v-button
                    >
                </div>
            </div>
        </v-dialog>
    </div>
</template>

<script setup>
import { onBeforeMount, ref, watch, inject } from "vue";
import { storeToRefs } from "pinia";

import { useRoleStore } from "@/stores/roleStore";

const roleStore = useRoleStore();
const { isExist, roles, form, loading, errors } = storeToRefs(roleStore);

const search = ref("");

const router = inject("router");

const showInsert = ref(false);
const showDelete = ref(false);

const current_role = ref(0);
await roleStore.getRoles();
</script>

<style lang="scss" scoped></style>
