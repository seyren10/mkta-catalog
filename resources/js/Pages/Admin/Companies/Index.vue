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
                prepend-inner-icon="px-buildings"
                class="float-end block rounded-lg bg-accent p-2 text-white"
                @click="(showInsert = true), companyStore.resetForm()"
                >New Company</v-button
            >
        </div>
        <v-text-field prepend-inner-icon="la-search-solid" v-model="search" />
        <v-data-table
            class="my-2"
            :headers="company_headers"
            :items="companies"
            :search="search"
        >
            <template #item.action="{ item }">
                <div class="max-w-40">
                    <v-button
                        class="w-full bg-red-600 text-white"
                        @click="
                            () => {
                                showDelete = true;
                                current_company = item.raw.id;
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
                                showUpdate = true;
                                current_company = item.raw.id;

                                form.title = item.raw.title;
                                form.description = item.raw.description;
                            }
                        "
                        outlined
                        prepend-inner-icon="hi-solid-pencil-alt"
                    >
                        Edit
                    </v-button>
                </div>
            </template>
            <template #item.title="{ item }">
                <p class="text-xl">{{ item.value }}</p>
                <span class="text-gray-400">{{ item.raw.description }}</span>
            </template>
        </v-data-table>
        <v-dialog
            v-model="showInsert"
            persistent
            title="Company"
            @close="companyStore.resetForm()"
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
                                companyStore.addCompany();
                                companyStore.getCompanies();
                                showInsert = false;
                            }
                        "
                        class="my-2 block rounded-lg bg-accent p-2 text-lg text-white disabled:bg-gray-500"
                        >Save Company</v-button
                    >
                </div>
            </div>
        </v-dialog>
        <v-dialog
            v-model="showUpdate"
            persistent
            title="Company"
            @close="companyStore.resetForm()"
        >
            <div class="min-w-[800px] p-5">
                <div class="">
                    <v-text-field
                        label="Title"
                        v-model="form.title"
                        @keyup="
                            form.key = form.title
                                .trim()
                                .toLowerCase()
                                .replace(/ /g, '-')
                        "
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
                        @click="
                            () => {
                                companyStore.updateCompany(
                                    current_company,
                                );
                                companyStore.getCompanies();
                                showUpdate = false;
                            }
                        "
                        class="my-2 block rounded-lg bg-accent p-2 text-lg text-white disabled:bg-gray-500"
                        >Save Company</v-button
                    >
                </div>
            </div>
        </v-dialog>
        <v-dialog
            v-model="showDelete"
            persistent
            title="Company"
            @close="companyStore.resetForm()"
        >
            <div class="min-w-[800px] p-5">
                <div class="">
                    Are you sure you want to delete
                    <span class="rounded-lg bg-black px-2 text-white">{{
                        form.title
                    }}</span>
                    Company?
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
                                companyStore.deleteCompany(
                                    current_company,
                                );
                                companyStore.getCompanies();
                                showDelete = false;
                            }
                        "
                        >Yes</v-button
                    >
                    <v-button
                        class="bg-green-500 text-white"
                        @click="
                            () => {
                                current_company = -1;
                                showDelete = false;
                                companyStore.resetForm();
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
import { onBeforeMount, inject, ref, watch } from "vue";
import { storeToRefs } from "pinia";
const router = inject("router");

import { useCompanyStore } from "@/stores/companyStore";
const companyStore = useCompanyStore();
const { isExist, companies, form, loading, errors } = storeToRefs(companyStore);
await companyStore.getCompanies();

const search = ref("");
const company_headers = ref([
    {
        value: "id",
        key: "id",
        hidden: true,
        sortable: false,
    },
    {
        value: "",
        key: "title",
        hidden: !true,
        sortable: false,
    },
    {
        value: "Description",
        key: "description",
        hidden: true,
        sortable: false,
    },
    {
        value: "",
        key: "action",
        hidden: false,
        sortable: false,
    },
]);


const showInsert = ref(false);
const showUpdate = ref(false);
const showDelete = ref(false);

const current_company = ref(0);


</script>

<style lang="scss" scoped></style>
