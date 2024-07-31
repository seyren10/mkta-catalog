<template>
    <div class="relative flex-1 rounded-lg border p-3 space-y-3">
        <span
            class="absolute -top-2 left-[50%] -translate-x-[50%] bg-white text-xs"
        >
            Auto-layout</span
        >

        <CMSButton @select="handleAddComponent"></CMSButton>

        <component
            v-for="child in children"
            :key="child.component.props.id"
            :is="child.component.type"
            v-bind="child.component.props"
        ></component>
    </div>
</template>

<script setup>
import CMSButton from "../CMSButton/CMSButton.vue";
import { useCMSStore } from "../../../../../stores/ui/CMSStore";

const props = defineProps({
    id: String,
    parentId: String,
    children: Array,
});
const cmsStore = useCMSStore();

function handleAddComponent(node) {
    cmsStore.addToNodes(node, props.id);
}
</script>

<style lang="scss" scoped></style>
