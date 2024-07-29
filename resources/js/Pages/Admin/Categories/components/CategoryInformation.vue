<template>
    <!-- <v-card class="border-0"> -->
    <div class="grid grid-cols-3 gap-0">
        <div class="col-span-3 md:col-span-1">
            <v-text-on-image
                class="border bg-gray-400 p-2"
                title="Thumbnail"
                subtitle="subtitle"
                align="center"
                :noOverlay="true"
                :appear="false"
                :image="s3(category.img)"
            />
            <v-button
                @click="insertCategoryImage.show = true"
                class="my-2 w-full bg-accent text-white"
                ><v-icon name="bi-card-image" class="me-2"></v-icon> Select
                Cover Photo
            </v-button>
        </div>

        <div class="col-span-3 md:col-span-1">
            <v-text-on-image
                class="border bg-gray-400 p-2 aspect-video"
                title="Thumbnail"
                subtitle="subtitle"
                align="center"
                :noOverlay="true"
                :appear="false"
                :image="bannerImage"
            />
            <v-button
                @click="fileUploadDialog = true"
                class="my-2 w-full bg-accent text-white"
                ><v-icon name="bi-card-image" class="me-2"></v-icon>Update
                Banner Image
            </v-button>
        </div>
        <div class="col-span-3 px-2 md:col-span-2">
            <div class="grid grid-cols-1 gap-y-2">
                <v-text-field
                    prepend-inner-icon="px-subtitles"
                    label="Title"
                    v-model="form.title"
                />
                <v-text-field
                    prepend-inner-icon="bi-text-paragraph"
                    label="Description"
                    v-model="form.description"
                />
                <v-textarea
                    :rows="10"
                    label="Cover"
                    @keyup="fix_content()"
                    v-model="form.cover_html"
                >
                    <!-- <template #prepend-inner>
                        <v-icon name="bi-filetype-html"></v-icon>
                    </template> -->
                </v-textarea>
                <v-button
                    @click="categoryStore.updateCategory(id)"
                    prepend-inner-icon="md-save-round"
                    class="ml-auto bg-accent text-white"
                    >Update Category</v-button
                >
                <ul>
                    <li>
                        Note: Cover HTML container class is
                        <code
                            class="rounded-sm bg-red-300 p-1 font-bold text-black"
                            >grid gap-5 overflow-hidden rounded-b-lg bg-white
                            p-10 md:grid-cols-2 md:grid-rows-[min] mb-5</code
                        >
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-span-3 px-2">
            Cover HTML preview
            <header
                class="mb-5 grid gap-5 overflow-hidden rounded-b-lg bg-white p-10 md:grid-cols-2 md:grid-rows-[min]"
                v-html="tempContent"
            ></header>
        </div>
        <v-dialog
            v-model="insertCategoryImage.show"
            persistent
            title="Category Image"
            @close="close_insertCategoryImage_data()"
        >
            <div class="min-w-[800px] p-5">
                <fileIndex
                    @submitSelection="submit_insertCategorymage_data"
                    @close="close_insertCategoryImage_data()"
                    @cancel="close_insertCategoryImage_data()"
                    :showHeader="false"
                    :isSelection="true"
                    :allowMultiple="false"
                    :filterType="'image'"
                />
            </div>
        </v-dialog>

        <v-dialog v-model="fileUploadDialog" persistent max-width="1000">
            <template #header="props">
                <div class="flex items-center justify-between p-3">
                    <h3 class="text-sm font-medium">Select Banner Image</h3>
                    <v-button
                        icon="md-close-round"
                        icon-size="1"
                        v-bind="props"
                    ></v-button>
                </div>
            </template>

            <CMSImageFileSelection
                items-per-page="30"
                @submit="handleUpdloadBanner"
            ></CMSImageFileSelection>
        </v-dialog>
    </div>
    <!-- </v-card> -->
</template>
<script setup>
import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";

import CMSImageFileSelection from "../../CMS/Catalog/CMSImage/CMSImageFileSelection.vue";

const router = inject("router");
const props = defineProps({
    id: String,
});

import { useCategoryStore } from "@/stores/categoryStore";
const categoryStore = useCategoryStore();
const addToast = inject("addToast");
const { category, form, loading, errors } = storeToRefs(categoryStore);
const refresh = async () => {
    await categoryStore.getCategory(props.id);
};
if (!category.length) {
    refresh();
}

const s3 = inject("s3");
const fileUploadDialog = ref(false);
import fileIndex from "../../Files/Index.vue";
const insertCategoryImage = ref({ show: false, file_id: -1 });
const tempContent = ref(false);

const bannerImage = computed(() => {
    console.log(category.value.banner_file?.title);
    return s3(category.value.banner_file?.filename);
});
const close_insertCategoryImage_data = () => {
    insertCategoryImage.value.show = false;
};
const submit_insertCategorymage_data = async (data) => {
    let curData = data[0];
    await categoryStore.updateCategoryImage(props.id, curData.id);
    close_insertCategoryImage_data();
};
const fix_content = () => {
    tempContent.value = form.value.cover_html;

    [
        {
            keyword: "{{category_title}}",
            value: category.value.title,
        },
        {
            keyword: "{{category_description}}",
            value: category.value.description,
        },
        {
            keyword: "{{category_image}}",
            value: s3(category.value.img),
        },
    ].forEach((element) => {
        let regex = new RegExp(element.keyword, "g");
        tempContent.value = tempContent.value.replace(regex, element.value);
    });
};

async function handleUpdloadBanner(file) {
    if (file.length <= 1) {
        await categoryStore.updateBannerImage(props.id, file.at(0).id);

        if (!errors.value) {
            fileUploadDialog.value = false;
            addToast({
                props: {
                    type: "success",
                },
                content: "Banner image updated successfully.",
            });
            await refresh();
        }
    }
}

fix_content();
</script>

<style lang="scss" scoped></style>
