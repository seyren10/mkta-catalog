<template>
    <div class="flex flex-wrap gap-4">
        <component
            v-for="node in nodes"
            :key="node.component.props.id"
            :is="node.component.type"
            v-bind="node.component.props"
            :data="node.data"
        />

        <div class="shrink-0 basis-full">
            <v-button
                class="bg-accent text-xs text-white"
                @click="handleSaveNodes"
                >Save CMS</v-button
            >
        </div>
    </div>
</template>

<script setup>
import { useCMSStore } from "../../../../stores/ui/CMSStore";
import { storeToRefs } from "pinia";
import { inject, onBeforeUnmount, onMounted } from "vue";

import ToolbarButton from "./ToolbarButton.vue";

const cmsStore = useCMSStore();
const { nodes } = storeToRefs(cmsStore);
const addToast = inject("addToast");
const setToolbarComponent = inject("setToolbarComponent");

function handleSaveNodes() {
    cmsStore.saveNodes();

    addToast({
        props: {
            type: "success",
        },
        content: "Catalog Contents saved.",
    });
}

onMounted(() => {
    setToolbarComponent(ToolbarButton);
    cmsStore.getNodes();
});

onBeforeUnmount(() => {
    setToolbarComponent(null);
});
</script>

<style lang="scss" scoped></style>
