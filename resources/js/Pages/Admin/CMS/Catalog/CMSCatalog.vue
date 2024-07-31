<template>
    <div class="flex flex-wrap gap-4">
        <CMSButton @select="handleAddComponent" class="basis-full"></CMSButton>

        <component
            v-for="node in nodes"
            :key="node.component.props.id"
            :is="node.component.type"
            v-bind="node.component.props"
        />
    </div>
</template>

<script setup>
import CMSButton from "./CMSButton/CMSButton.vue";
import { useCMSStore } from "../../../../stores/ui/CMSStore";
import { storeToRefs } from "pinia";

const cmsStore = useCMSStore();
const { nodes } = storeToRefs(cmsStore);

function handleAddComponent(node) {
    cmsStore.addToNodes(node);
}
</script>

<style lang="scss" scoped></style>
