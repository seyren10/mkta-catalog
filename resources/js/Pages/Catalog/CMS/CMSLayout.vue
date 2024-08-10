<template>
    <div
        class="col-span-full grid gap-4 rounded-lg border bg-white p-4 md:grid-cols-12"
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
});
</script>

<style lang="scss" scoped></style>
