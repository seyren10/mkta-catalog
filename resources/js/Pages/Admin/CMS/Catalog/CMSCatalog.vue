<template>
    <div>
        <component
            :is="{ ...parentNode.component }"
            v-bind="parentNode.props"
        ></component>
    </div>
</template>

<script setup>
import { storeToRefs } from "pinia";
import { useCMSStore } from "../../../../stores/ui/CMSStore";

const CMSStore = useCMSStore();
const { parentNode } = storeToRefs(CMSStore);
</script>

<style lang="scss" scoped></style>
