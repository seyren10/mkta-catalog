<template>
    <div class="flex flex-wrap gap-4">
        <CMSButton @select="handleAddComponent" class="basis-full"></CMSButton>

        <component
            v-for="node in nodes"
            :key="node.component.props.id"
            :is="node.component.type"
            v-bind="node.component.props"
            :data="node.data"
        />

        <v-button class="bg-accent text-xs text-white" @click="handleSaveNodes"
            >Save CMS</v-button
        >
    </div>
</template>

<script setup>
import CMSButton from "./CMSButton/CMSButton.vue";
import { useCMSStore } from "../../../../stores/ui/CMSStore";
import { storeToRefs } from "pinia";
import { inject, onBeforeMount, onMounted } from "vue";

const cmsStore = useCMSStore();
const { nodes } = storeToRefs(cmsStore);
const addToast = inject("addToast");

function handleAddComponent(node) {
    cmsStore.addToNodes(node);
}

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
    cmsStore.getNodes();
});
</script>

<style lang="scss" scoped></style>
