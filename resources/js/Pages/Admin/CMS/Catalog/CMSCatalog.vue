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

const cmsUIStore = useCMSUIStore();
const { nodes } = storeToRefs(cmsUIStore);
const cmsStore = useCMSStore();
const { errors: cmsErrors, loading: cmsLoading } = storeToRefs(cmsStore);
const addToast = inject("addToast");
const setToolbarComponent = inject("setToolbarComponent");

const databaseNodes = await cmsStore.getContent(13);
cmsUIStore.getNodes(databaseNodes);

async function handleSaveNodes() {
    const form = {
        title: "sample1",
        data: JSON.stringify(nodes.value),
    };
    await cmsStore.addContent(form);

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

onMounted(() => {
    setToolbarComponent(ToolbarButton);
});

onBeforeUnmount(() => {
    setToolbarComponent(null);
});
</script>

<style lang="scss" scoped></style>
