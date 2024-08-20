<template>
    <div class="grid grid-cols-12 gap-4">
        <component
            v-for="node in nodes"
            :key="node.component.props.id"
            :is="node.component.type"
            v-bind="node.component.props"
            :data="node.data"
        />
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

const { nodes } = await useTemplate();

async function useTemplate() {
    const cmsStore = useCMSStore();
    const cmsUIStore = useCMSUIStore();
    const {
        errors: cmsErrors,
        loading: cmsLoading,
        templates,
        editingTemplate,
    } = storeToRefs(cmsStore);
    const { nodes } = storeToRefs(cmsUIStore);

    await cmsStore.getContents();

    const data = JSON.parse(editingTemplate.value.data);
    cmsUIStore.getNodes(data);

    return {
        cmsErrors,
        cmsLoading,
        templates,
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
