<template>
    <div
        class="relative flex grow flex-wrap justify-between gap-3 rounded-lg border p-3"
        :class="`${type === 'grid' ? 'w-full shrink-0' : ''}`"
    >
        <div class="flex w-full shrink-0 items-start justify-between">
            <CMSButton @select="handleAddChildren"></CMSButton>
            <button
                v-if="!notClosable"
                class="rounded-lg border p-[.32rem] py-[.2rem]"
                @click="handleRemoveNode"
            >
                <v-icon name="la-times-solid" scale=".8"></v-icon>
            </button>
        </div>

        <component
            v-for="child in children"
            :key="child.props.id"
            :is="{ ...child.component }"
            v-bind="child.props"
        ></component>

        <div
            class="absolute -top-3 left-[50%] translate-x-[-50%] bg-white px-3 text-[.7rem]"
        >
            <h3 class="font-medium text-slate-500">{{ type }}</h3>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useCMSStore } from "../../../../../stores/ui/CMSStore";

import CMSButton from "../CMSButton/CMSButton.vue";

const props = defineProps({
    children: Array,
    notClosable: Boolean,
    id: String,
    parentId: String,
    type: String,
});
const CMSStore = useCMSStore();
const uniqueId = ref(null);

function handleAddChildren(node) {
    uniqueId.value = Math.floor(Math.random() * 10_000).toString();
    const child = {
        component: node.component,
        props: {
            id: uniqueId.value,
            parentId: props.id,
            children: [],
            type: node.type,
        },
    };

    CMSStore.addNode(child);
}

function handleRemoveNode(node) {
    CMSStore.removeNode({ props: { id: props.id, parentId: props.parentId } });
}
</script>

<style lang="scss" scoped></style>
