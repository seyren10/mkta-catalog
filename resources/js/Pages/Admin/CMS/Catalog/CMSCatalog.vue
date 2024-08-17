<template>
    <div class="grid grid-cols-12 gap-4">
        <component
            v-for="node in nodes"
            :key="node.component.props.id"
            :is="node.component.type"
            v-bind="node.component.props"
            :data="node.data"
        />

        <div class="col-span-full">
            <v-button
                class="bg-accent text-xs text-white"
                @click="updateContent"
                :loading="cmsLoading"
                >Save CMS</v-button
            >
        </div>
    </div>
</template>

<script setup>
import { storeToRefs } from "pinia";
import { inject, onBeforeUnmount, onMounted } from "vue";
import { useCMSUIStore } from "../../../../stores/ui/CMSUIStore";
import { useCMSStore } from "../../../../stores/CMSStore";

import ToolbarButton from "./ToolbarButton.vue";

const addToast = inject("addToast");
const setToolbarComponent = inject("setToolbarComponent");

const { cmsLoading, updateContent, nodes } = await useTemplate();

// const databaseNodes = await cmsStore.getContent(13);
// cmsUIStore.getNodes(databaseNodes);

async function useTemplate() {
    const cmsStore = useCMSStore();
    const cmsUIStore = useCMSUIStore();
    const {
        errors: cmsErrors,
        loading: cmsLoading,
        templates,
        activeTemplate,
    } = storeToRefs(cmsStore);
    const { nodes } = storeToRefs(cmsUIStore);

    await cmsStore.getContents();

    const data = JSON.parse(activeTemplate.value.data);
    cmsUIStore.getNodes(data);

    async function updateContent() {
        const form = {
            data: JSON.stringify(nodes.value),
        };

        await cmsStore.updateContent(activeTemplate.value.id, form);

        if (cmsErrors.value) {
            addToast({
                props: {
                    type: "danger",
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
    return {
        cmsErrors,
        cmsLoading,
        templates,
        updateContent,
        nodes,
    };
}

onMounted(() => {
    setToolbarComponent(ToolbarButton);
});

onBeforeUnmount(() => {
    setToolbarComponent(null);
});
</script>

<style lang="scss" scoped></style>
