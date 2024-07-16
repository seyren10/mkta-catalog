<template>
    <div class="pt-2">
        <div v-show="showHeader">
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
        <div class="my-2">
            <v-button
                @click="insertOpen()"
                outlined
                prepend-inner-icon="fa-cloud-upload-alt"
                class="ml-auto rounded-lg bg-accent p-2 text-white"
                >Upload File(s)</v-button
            >
        </div>
        <v-text-field prepend-inner-icon="la-search-solid" v-model="search" />
        <div v-show="!allowMultiple" class="my-2 text-xl">Select one only</div>
        <div v-show="allowMultiple && isSelection" class="my-2 text-xl">
            Selected: {{ selectedItemKeys.length }} items
        </div>
        <v-data-table
            class="my-2"
            :headers="file_headers"
            :items="
                filterType == ''
                    ? files.filter((item) => item.type.includes(filterType))
                    : files
            "
            :search="search"
        >
            <template #item.selection="{ item }">
                <div class="flex justify-end">
                    <v-icon
                        :color="isSelected(item.raw.id) ? 'green' : 'black'"
                        class="ml-auto"
                        scale="2"
                        :name="
                            isSelected(item.raw.id)
                                ? 'bi-check-circle-fill'
                                : 'bi-circle'
                        "
                        @click="
                            () => {
                                if (isSelected(item.raw.id)) {
                                    removeItem(item.raw);
                                } else {
                                    appendItem(item.raw);
                                }
                            }
                        "
                    />
                </div>
            </template>
            <template #item.details="{ item }">
                <div class="rounded-lg border p-2">
                    <p class="text-xl">{{ item.raw.title }}</p>
                    <span class="text-gray-400">{{ item.raw.type }}</span>
                    <div class="my-2 flex justify-between">
                        <v-button
                            @click="copyLink(item.raw)"
                            prepend-inner-icon="la-link-solid"
                            class="w-full border bg-gray-600 font-semibold text-white"
                            >Copy Link</v-button
                        >
                        <v-button
                            v-show="
                                new String(item.raw['type'])
                                    .toLowerCase()
                                    .includes('image')
                            "
                            @click="previewOpen(item.raw)"
                            prepend-inner-icon="fa-folder-open"
                            class="w-full border bg-green-600 font-semibold text-white"
                            >Preview</v-button
                        >
                        <v-button
                            v-show="
                                new String(item.raw['type'])
                                    .toLowerCase()
                                    .includes('image')
                            "
                            @click="renameOpen(item.raw.id, item.raw.title)"
                            prepend-inner-icon="md-drivefilerenameoutline-outlined"
                            class="w-full border bg-orange-600 font-semibold text-white"
                            >Rename</v-button
                        >
                        <v-button
                            :href="
                                [
                                    '/api/s3-resources-download',
                                    item.raw.filename,
                                ].join('/')
                            "
                            target="_blank"
                            tag="a"
                            prepend-inner-icon="fa-download"
                            class="w-full rounded-md border bg-indigo-600 p-2 font-semibold text-white"
                            >Download</v-button
                        >
                        <v-button
                            @click="deleteOpen(item.raw)"
                            v-show="true"
                            prepend-inner-icon="fa-trash-alt"
                            class="w-full border bg-red-600 font-semibold text-white"
                            >Delete</v-button
                        >
                    </div>
                </div>
            </template></v-data-table
        >
        <div class="my-2 flex justify-between" v-show="isSelection">
            <v-button
                @click="cancel"
                prepend-inner-icon="la-times-solid"
                class="w-full border bg-red-600 font-semibold text-white"
                >Cancel</v-button
            >
            <v-button
                @click="submit"
                prepend-inner-icon="la-check-solid"
                class="w-full rounded-md border bg-green-600 p-2 font-semibold text-white"
                >Submit</v-button
            >
        </div>
        <v-dialog
            v-model="deleteData.show"
            persistent
            title="File Delete"
            @close="deleteClose"
        >
            <div class="min-w-[800px] p-5">
                <div>
                    <p class="text-xl">{{ deleteData.data.title }}</p>
                    <span class="text-gray-400">{{
                        deleteData.data.type
                    }}</span>
                </div>
                <div class="my-4 flex justify-between">
                    <v-button
                        @click="deleteClose()"
                        prepend-inner-icon="la-times-solid"
                        class="w-full border bg-red-600 font-semibold text-white"
                        >No</v-button
                    >
                    <v-button
                        @click="deleteSubmit()"
                        prepend-inner-icon="la-check-solid"
                        class="w-full rounded-md border bg-green-600 p-2 font-semibold text-white"
                        >Yes</v-button
                    >
                </div>
            </div>
        </v-dialog>
        <v-dialog
            v-model="renameData.show"
            persistent
            title="File Rename"
            @close="renameClose"
        >
            <div class="min-w-[800px] p-5">
                <v-text-field v-model="renameData.rename" class="" />
                <div class="my-4 flex justify-between" v-show="isSelection">
                    <v-button
                        @click="renameClose"
                        prepend-inner-icon="la-times-solid"
                        class="w-full border bg-red-600 font-semibold text-white"
                        >Cancel</v-button
                    >
                    <v-button
                        @click="renameSubmit"
                        prepend-inner-icon="la-check-solid"
                        class="w-full rounded-md border bg-green-600 p-2 font-semibold text-white"
                        >Submit</v-button
                    >
                </div>
            </div>
        </v-dialog>
        <v-dialog
            v-model="showInsert"
            persistent
            title="File Upload"
            @close="insertClose()"
        >
            <div class="min-w-[800px] p-5">
                <fileInsert @close="insertClose()" @submit="insertClose()" />
            </div>
        </v-dialog>
        <v-dialog
            v-model="previewData.show"
            persistent
            title="Files"
            @close="previewClose()"
        >
            <div class="min-w-[800px] p-5">
                {{ previewData.isLoading ? " Loading " : "" }}
                <img
                    :onload="
                        () => {
                            previewData.isLoading = false;
                        }
                    "
                    :src="
                        ['/api/s3-resources', previewData.data.filename].join(
                            '/',
                        )
                    "
                    :alt="previewData.data.title"
                />
            </div>
        </v-dialog>
    </div>
</template>
<script setup>
//!SECTION - Components
import fileInsert from "./fileInsert.vue";

//SECTION - required
import { ref, computed, inject } from "vue";
import { storeToRefs } from "pinia";

//SECTION - Props
const props = defineProps({
    showHeader: {
        type: Boolean,
        default: true,
    },
    isSelection: {
        type: Boolean,
        default: false,
    },
    allowMultiple: {
        type: Boolean,
        default: true,
    },
    filterType: {
        type: String,
        default: "",
    },
});

//SECTION - Store
import { useFileStore } from "@/stores/fileStore";
const fileStore = useFileStore();
const { files, form } = storeToRefs(fileStore);
const refresh = async () => {
    await fileStore.getFiles();
};
if (!files.length) {
    refresh();
}
const file_headers = ref([]);
if (props.isSelection) {
    file_headers.value.push({
        value: "",
        key: "selection",
        hidden: false,
        sortable: true,
    });
}
file_headers.value.push({
    value: "Details",
    key: "details",
    hidden: false,
    sortable: true,
});
// file_headers.value.push({
//     value: "",
//     key: "actions",
//     hidden: false,
//     sortable: false,
// });

//SECTION - Variables
const renameData = ref({
    show: false,
    id: 0,
    rename: "",
});

const search = ref("");
const showInsert = ref(false);
const previewData = ref({
    show: false,
    data: {},
    isLoading: true,
});
const deleteData = ref({
    show: false,
    data: null,
});
const selectedItems = ref([]);
const selectedItemKeys = ref([]);

//SECTION - Emits
const emit = defineEmits(["submitSelection", "close", "cancel"]);

//SECTION - computed

//SECTION - Methods
const isSelected = (key) => {
    return selectedItemKeys.value.includes(key);
};

const appendItem = (item) => {
    if (!props.allowMultiple && selectedItemKeys.value.length == 1) {
        return;
    }
    selectedItems.value.push(item);
    selectedItemKeys.value.push(item.id);
};
const removeItem = (item) => {
    let index = selectedItemKeys.value.indexOf(item.id);
    selectedItems.value.splice(index, 1);
    selectedItemKeys.value.splice(index, 1);
};
const submit = () => {
    refresh();
    emit("submitSelection", selectedItems.value);
};
const cancel = () => {
    emit("close");
    emit("cancel");
};

const insertOpen = () => {
    showInsert.value = true;
};
const insertClose = () => {
    showInsert.value = false;
    form.file = null;
    refresh();
};

const s3 = inject("s3");
const copyText = inject("copyText");

const copyLink = (data) => {
    copyText(s3(data.filename));
};

const previewOpen = (data) => {
    previewData.value.show = true;
    previewData.value.data = data;
    previewData.value.isLoading = true;
};
const previewClose = () => {
    previewData.value.show = false;
    previewData.value.data = {};
    previewData.value.isLoading = true;
};

const renameSubmit = async () => {
    await fileStore.renameFile(renameData.value.id, renameData.value.rename);
    renameClose();
    refresh();
};
const renameOpen = (id, title) => {
    renameData.value.show = true;
    renameData.value.id = id;
    renameData.value.rename = title;
};
const renameClose = () => {
    renameData.value.show = false;
    renameData.value.id = 0;
};

const deleteOpen = (data) => {
    deleteData.value.data = data;
    deleteData.value.show = true;
};
const deleteSubmit = async () => {
    await fileStore.deleteFile(deleteData.value.data.id);
    deleteClose();
};
const deleteClose = () => {
    deleteData.value.data = null;
    deleteData.value.show = false;
    refresh();
};
</script>
