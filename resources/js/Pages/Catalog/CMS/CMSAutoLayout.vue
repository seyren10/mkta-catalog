<template>
    <div
        class="grid gap-4 md:grid-cols-12"
        :style="{ gridColumn: `span ${size} / span ${size}` }"
    >
        <component
            v-for="child in children"
            :key="child.component.props.id"
            :is="child.component.type"
            v-bind="child.component.props"
            :data="child.data"
        ></component>
    </div>
</template>

<script setup>
const props = defineProps({
    children: Array,
    size: Number,
});
</script>

<style lang="scss" scoped></style>
