<script setup>
import CMSFPDialog from "@/Pages/Admin/CMS/Catalog/CMSFeaturedProducts/CMSFPDialog.vue";

const props = defineProps({
    title: String,
});
const dialog = defineModel("dialog", { default: false });
const selectedRelatedProducts = defineModel("selected", { default: [] });
</script>
<template>
    <v-dialog v-model="dialog" max-width="800" persistent>
        <template #header="props">
            <div class="flex items-center justify-between p-3">
                <h3 class="text-sm font-medium">{{ title }}</h3>
                <v-button
                    icon="md-close-round"
                    icon-size="1"
                    v-bind="props"
                ></v-button>
            </div>
        </template>

        <CMSFPDialog
            v-model="selectedRelatedProducts"
            class="text-xs"
            @save="dialog = false"
        ></CMSFPDialog>
    </v-dialog>
</template>

<style lang="scss" scoped></style>
