<template>
    <div class="p-3">
        <CMSImageToolbar
            v-model="searchModel"
            @refresh="getFiles"
            @next="nextPage"
            @prev="prevPage"
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
                    <v-text-on-image
                        class="h-full w-full"
                        :image="s3(file.filename)"
                        :subtitle="file.title"
                    ></v-text-on-image>
                </li>
            </ul>
        </div>
        <div v-else class="flex items-center gap-3">
            <VLoader></VLoader>
            <h3>Fetching files from server.</h3>
        </div>
    </div>
</template>

<script setup>
import { inject, onMounted, ref, watch } from "vue";
import { storeToRefs } from "pinia";
import { useFileStore } from "../../../../../stores/fileStore";
import { usePaginate } from "../../../../../composables/usePaginate";

import VLoader from "@/components/base_components/VLoader.vue";
import CMSImageToolbar from "./CMSImageToolbar.vue";

const { files, getFiles, loading } = useFiles(useFileStore());
const { paginatedItems, nextPage, page, prevPage, totalPages } = usePaginate(
    files,
    100,
);

const searchModel = ref("");
const s3 = inject("s3");

onMounted(async () => {
    await getFiles();
});

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
</script>

<style lang="scss" scoped></style>
