<template>
    <div class="relative bg-white p-5">
        <component
            v-for="node in nodes"
            :key="node.component.props.id"
            :is="node.component.type"
            v-bind="node.component.props"
            :data="node.data"
        />

        <div
            class="fixed right-8 z-[100] top-4 space-y-4 rounded-lg bg-blue-400 p-3 text-white"
        >
            <div class="flex items-center gap-2">
                <span> Preview Mode </span>
                <v-icon name="pr-eye"></v-icon>

                <v-button
                    icon="la-times-solid"
                    icon-size=".9"
                    class="ml-auto"
                    @click="$emit('close')"
                ></v-button>
            </div>

            <div class="text-slate-200">(Escape key to quit preview)</div>
        </div>
    </div>
</template>

<script setup>
import { useCMSUIStore } from "../../../../stores/ui/CMSUIStore";
import { storeToRefs } from "pinia";

const emits = defineEmits(["close"]);
const cmsUIStore = useCMSUIStore();
const { nodes } = storeToRefs(cmsUIStore);

cmsUIStore.getNodes(nodes.value, "preview");
</script>

<style lang="scss" scoped></style>
