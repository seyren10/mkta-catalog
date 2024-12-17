<template>
    <div class="relative p-3">
        <CMSImageToolbar
            @refresh="getFiles"
            @upload="openUploadDialog = true"
            @next="nextPage"
            @prev="prevPage"
            v-model="search"
            :page-info="{ currentPage: page, totalPages }"
            class="sticky top-0 z-10"
        ></CMSImageToolbar>

        <div v-if="!loading">
            <ul class="flex flex-wrap justify-center gap-2">
                <li
                    v-for="file in paginatedItems"
                    :key="file.id"
                    class="aspect-square max-w-40"
                >
                    <div
                        role="button"
                        class="relative"
                        @click.stop="handleSelect(file)"
                    >
                        <v-text-on-image
                            :image="s3Thumbnail(file.filename)"
                            :subtitle="file.title"
                            no-overlay
                        >
                            <template #default="{ data }">
                                <div
                                    class="bg-slate-100 p-1 text-xs text-slate-500"
                                >
                                    <strong class="line-clamp-1">{{
                                        data.title
                                    }}</strong>
                                    <p class="line-clamp-2">
                                        {{ data.subtitle }}
                                    </p>
                                </div>
                            </template>
                        </v-text-on-image>
                        <v-icon
                            v-if="selectedItems.find((e) => e.id === file.id)"
                            name="bi-check"
                            class="absolute left-2 top-2 rounded-full bg-green-500 fill-white"
                        ></v-icon>
                    </div>
                </li>
            </ul>
        </div>
        <div v-else class="flex items-center gap-3">
            <VLoader></VLoader>
            <h3>Fetching files from server.</h3>
        </div>

        <CMSImageFooter
            @clear="handleClearSelection"
            @submit="handleSubmit"
            v-model="showSelected"
            class="sticky bottom-0 z-10 mt-10"
        >
            <p>
                <strong>{{ selectedItems.length }}</strong> file(s) selected.
            </p>
        </CMSImageFooter>

        <CMSImageUploadDialog
            v-model="openUploadDialog"
            max-width="500"
            @upload="handleSelectImages"
        >
            <div class="space-y-4 p-3 text-xs">
                <p v-if="!selectedUploadFiles?.length">
                    No Files has been selected.
                </p>
                <ul class="space-y-2">
                    <li
                        v-for="uploadFile in selectedUploadFiles"
                        class="flex items-center gap-2"
                    >
                        <v-icon
                            name="bi-dot"
                            class="fill-gray-400"
                            v-if="uploadFile.status === 'pending'"
                        ></v-icon>
                        <v-icon
                            v-else-if="uploadFile.status === 'uploading'"
                            name="pr-spinner"
                            class="animate-spin fill-gray-400"
                        ></v-icon>
                        <v-icon
                            v-else-if="uploadFile.status === 'failed'"
                            name="la-times-solid"
                            class="fill-red-400"
                        ></v-icon>
                        <v-icon
                            name="pr-cloud"
                            class="fill-green-400"
                            v-else
                        ></v-icon>
                        <span>{{ uploadFile.file.name }}</span>
                    </li>
                </ul>
                <div v-if="selectedUploadFiles.length" class="space-y-4">
                    <v-alert type="warning">
                        Important: Please do not close this window while the
                        upload is in progress.</v-alert
                    >
                    <v-button
                        class="w-full bg-primary text-white"
                        @click="handleUploadFiles"
                        :loading="uploadLoading"
                        >Upload</v-button
                    >
                </div>
            </div>
        </CMSImageUploadDialog>
    </div>
</template>

<script setup>
import {
    computed,
    inject,
    onBeforeMount,
    provide,
    ref,
    watchEffect,
} from "vue";
import { storeToRefs } from "pinia";
import { useFileStore } from "../../../../../stores/fileStore";
import { usePaginate } from "../../../../../composables/usePaginate";

import VLoader from "@/components/base_components/VLoader.vue";
import CMSImageToolbar from "./CMSImageToolbar.vue";
import CMSImageFooter from "./CMSImageFooter.vue";
import CMSImageUploadDialog from "./CMSImageUploadDialog.vue";

const props = defineProps({
    itemsPerPage: {
        type: [Number, String],
        default: 25,
    },
    multiple: Boolean,
    items: Array,
});

const s3Thumbnail = inject("s3Thumbnail");
const addToast = inject("addToast");
const emits = defineEmits(["submit"]);
const { files, getFiles, loading } = useFiles(useFileStore());
const search = ref("");
const showSelected = ref(false);
const { handleClearSelection, handleSelect, selectedItems } = useSelection(
    props.items,
);
const {
    openUploadDialog,
    handleSelectImages,
    selectedUploadFiles,
    handleUploadFiles,
    uploadLoading,
} = useUpload();

const searchItems = computed(() => {
    if (showSelected.value) {
        page.value = 1;
        return selectedItems.value;
    }

    return files.value.filter((e) => {
        return e.title.toLowerCase().includes(search.value.toLowerCase());
    });
});

const { paginatedItems, nextPage, page, prevPage, totalPages } = usePaginate(
    searchItems,
    +props.itemsPerPage,
);

function handleSubmit() {
    emits("submit", selectedItems.value);
}

function useFiles(fileStore) {
    const { files } = storeToRefs(fileStore);
    const loading = ref(false);

    async function getFiles() {
        loading.value = true;
        await fileStore.getFiles();
        loading.value = false;
    }
    return { files, getFiles, loading };
}

function useSelection(selected = []) {
    const selectedItems = ref(selected);

    function handleSelect(item) {
        if (!props.multiple) {
            selectedItems.value[0] = item;
            return;
        }

        const foundItem = selectedItems.value.find((e) => {
            return e.id === item.id;
        });

        /* delete the item when exist in selectedItems  */
        if (foundItem) {
            selectedItems.value = selectedItems.value.filter(
                (e) => e.id !== foundItem.id,
            );
        } else {
            selectedItems.value.push(item);
        }
    }

    function handleClearSelection() {
        selectedItems.value = [];
    }

    provide(
        "selectedItemsCount",
        computed(() => selectedItems.value.length),
    );

    return { handleSelect, handleClearSelection, selectedItems };
}

function useUpload() {
    const fileStore = useFileStore();
    const { form, errors } = storeToRefs(fileStore);
    const openUploadDialog = ref(false);
    const selectedUploadFiles = ref([]);
    const uploadLoading = ref(false);

    function handleSelectImages(event) {
        if (event.target?.files?.length) {
            for (const file of event.target.files) {
                selectedUploadFiles.value.push({
                    id: crypto.randomUUID(),
                    file: file,
                    status: "pending",
                });
            }
        }
    }

    async function handleUploadFiles() {
        for (const file of selectedUploadFiles.value) {
            file.status = "uploading";
            uploadLoading.value = true;
            form.value = {
                title: file.file.name,
                eFile: file.file,
            };
            await fileStore.uploadFile();

            if (!errors.value) {
                file.status = "completed";
                uploadLoading.value = false;
            } else {
                uploadLoading.value = false;
                file.status = "failed";

                addToast({
                    props: {
                        type: "danger",
                    },
                    content: "Something went wrong, please try again later.",
                });
                break;
            }
        }

        await fileStore.getFiles();
    }

    return {
        openUploadDialog,
        selectedUploadFiles,
        handleSelectImages,
        handleUploadFiles,
        uploadLoading,
    };
}

onBeforeMount(async () => {
    await getFiles();
});
</script>

<style lang="scss" scoped></style>
