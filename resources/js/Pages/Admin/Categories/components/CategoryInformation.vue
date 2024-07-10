<template>
    <!-- <v-card class="border-0"> -->
    <div class="grid grid-cols-3 gap-0">
        <div class="col-span-3 md:col-span-1">
            <v-text-on-image
                class="bg-gray-400 p-2 border"
                title="Thumbnail"
                subtitle="subtitle"
                align="center"
                :noOverlay="true"
                :appear="false"
                :image="s3(category.img)"
            />
            <v-button @click="insertCategoryImage.show = true" class="w-full bg-accent my-2 text-white"><v-icon name="bi-card-image" class="me-2"></v-icon> Select Cover Photo </v-button>
        </div>
        <div class="col-span-3 px-2 md:col-span-2">
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
            <div class="col-span-12 md:col-span-6">
                <v-button
                    @click="categoryStore.updateCategory(id)"
                    prepend-inner-icon="md-save-round"
                    class="ml-auto bg-accent text-white"
                    >Update Category</v-button
                >
            </div>
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
    </div>
    <!-- </v-card> -->
</template>
<script setup>
import { onBeforeMount, ref, watch, computed, inject } from "vue";
import { storeToRefs } from "pinia";

const router = inject("router");
const props = defineProps({
    id: String,
});

import { useCategoryStore } from "@/stores/categoryStore";
const categoryStore = useCategoryStore();
const { category, form, loading, errors } = storeToRefs(categoryStore);
const refresh = async()=>{
    await categoryStore.getCategory(props.id);
}
if (!category.length) {
    refresh();
}

const s3 = inject("s3");
import fileIndex from "../../Files/Index.vue";

const insertCategoryImage = ref({ show: false, file_id: -1 });
const close_insertCategoryImage_data = () => {
    insertCategoryImage.value.show = false;
};
const submit_insertCategorymage_data = async(data) => {
    let curData = data[0]
    await categoryStore.updateCategoryImage(props.id, curData.id);
    close_insertCategoryImage_data();
};
</script>

<style lang="scss" scoped></style>
