<template>
    <div>
        <div
            class="flex gap-2 rounded-md p-2 [&:not(:last-child)]:border-b-2"
            v-for="item in items"
        >
            <v-icon :name="item.icon" scale="1.5"></v-icon>
            <div>
                <div class="font-medium">{{ item.title }}</div>
                <span>{{ item.value }} </span>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    items: {
        type: Array,
    },
});
</script>

<style lang="scss" scoped></style>
