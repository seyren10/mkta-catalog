<template>
    <div class="flex items-center gap-4 text-xs">
        <div class="flex items-center gap-3">
            <v-icon name="hi-template" class="text-slate-400"></v-icon>
            <ToolbarButtonMenu></ToolbarButtonMenu>
        </div>
        <div class="text-slate-400">|</div>

        <div class="flex items-center gap-2">
            <CMSButton @select="addToNodes">
                <template #button="buttonProps">
                    <v-button
                        v-bind="buttonProps"
                        icon="hi-plus-sm"
                        class="text-accent"
                    ></v-button>
                </template>
            </CMSButton>

            <AppDialog full-screen @close="getAdminNodes" class="grid h-full">
                <template #activator="{ props }">
                    <v-button
                        v-bind="props"
                        class="text-xs text-accent"
                        icon="pr-eye"
                        :loading="cmsLoading"
                        >Save CMS</v-button
                    >
                </template>

                <template #default="{ props }">
                    <ToolbarButtonPreviewDialog
                        @close="props.closeDialog()"
                    ></ToolbarButtonPreviewDialog>
                </template>
            </AppDialog>

            <v-button
                class="text-xs text-accent"
                icon="hi-save"
                @click="updateContent"
                :loading="cmsLoading"
                >Save CMS</v-button
            >
        </div>
    </div>
</template>

<script setup>
import { inject, ref } from "vue";
import { useCMSUIStore } from "../../../../stores/ui/CMSUIStore";
import { useCMSStore } from "../../../../stores/CMSStore";
import { storeToRefs } from "pinia";

import CMSButton from "./CMSButton/CMSButton.vue";
import ToolbarButtonMenu from "./ToolbarButtonMenu.vue";
import AppDialog from "../../../../components/Dialog/AppDialog.vue";
import ToolbarButtonPreviewDialog from "./ToolbarButtonPreviewDialog.vue";

const { cmsLoading, updateContent, addToNodes, getAdminNodes } = useTemplate();
const addToast = inject("addToast");

function useTemplate() {
    const cmsStore = useCMSStore();
    const cmsUIStore = useCMSUIStore();
    const { nodes } = storeToRefs(cmsUIStore);
    const {
        editingTemplate,
        loading: cmsLoading,
        errors: cmsErrors,
    } = storeToRefs(cmsStore);

    async function updateContent() {
        const form = {
            data: JSON.stringify(nodes.value),
        };

        await cmsStore.updateContent(editingTemplate.value.id, form);

        if (cmsErrors.value) {
            addToast({
                props: {
                    type: "danger",
                    align: "bottom-center",
                },
                content: "Something went wrong",
            });
        } else
            addToast({
                props: {
                    type: "success",
                },
                content: "Catalog Contents saved.",
            });
    }

    function addToNodes(node) {
        cmsUIStore.addToNodes(node);
    }

    function getAdminNodes() {
        cmsUIStore.getNodes(nodes.value);
    }

    return {
        updateContent,
        cmsLoading,
        addToNodes,
        getAdminNodes,
    };
}
</script>

<style lang="scss" scoped></style>
