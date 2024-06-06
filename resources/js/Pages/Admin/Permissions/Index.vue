<template>
    <div class="pt-2">
        <v-heading type="h2">Permissions </v-heading>
        <p>
            Efficiently manage access control and ensure data security within
            the Catalog.
        </p>
        <div class="ml-auto w-fit">
            <v-button
                outlined
                prepend-inner-icon="gi-checked-shield"
                class="float-end block rounded-lg bg-accent p-2 text-white"
                @click="showDialog = true"
                >New Permission</v-button
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
                        value: 'id',
                        key: 'id',
                        hidden: true,
                        sortable: false,
                    },
                    {
                        value: '',
                        key: 'key',
                        hidden: true,
                        sortable: false,
                    },
                    {
                        value: 'Title',
                        key: 'title',
                        hidden: !true,
                        sortable: false,
                    },
                    {
                        value: 'Description',
                        key: 'description',
                        hidden: !true,
                        sortable: false,
                    },
                ]"
                :items="permissions"
                :search="search"
                striped
                border
            >
                <template #item.title="{ item }">
                    <p class="text-xl">{{ item.value }}</p>
                    <span class="text-gray-400">{{ item.raw.key }}</span>
                </template>
            </v-data-table>
        </div>
        <!-- </template> -->
        <v-dialog v-model="showDialog" persistent title="Permission">
            <div class="min-w-[800px] p-5">
                <div class="">
                    <v-text-field
                        label="Title"
                        v-model="form.title"
                        prepend-inner-icon="px-subtitles"
                        clearable
                    />
                    <hr class="my-2 " width="0%" />
                    <v-text-field
                        v-model="form.key"
                        label="Key"
                        prepend-inner-icon="bi-filetype-key"
                        clearable
                    />
                    <hr class="my-2 " width="0%" />
                    <v-textarea
                        rows="5"
                        v-model="form.desc"
                        label="Title"
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
                        class="my-2 block rounded-lg bg-accent p-2 text-lg text-white"
                        >Save Permission</v-button
                    >
                </div>
            </div>
        </v-dialog>
    </div>
</template>

<script setup>
import { onBeforeMount, ref } from "vue";
import { storeToRefs } from "pinia";

import { usePermissionStore } from "@/stores/permissionStore";

const permissionStore = usePermissionStore();
const { permissions, form, loading, errors } = storeToRefs(permissionStore);
const search = ref("");

const showDialog = ref(false);

await permissionStore.getPermissions();
</script>

<style lang="scss" scoped></style>
