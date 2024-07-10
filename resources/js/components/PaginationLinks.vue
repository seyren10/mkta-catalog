<template>
    <div class="flex flex-wrap justify-center gap-2 rounded-lg bg-white p-2">
        <v-button
            outlined
            v-for="(page, index) in items"
            :class="{
                'bg-accent text-white': page.active,
            }"
            :disabled="page.url === null"
            @click="$emit('pageChange', page)"
        >
            <v-icon
                v-if="index === 0"
                name="md-keyboardarrowleft-round"
            ></v-icon>
            <v-icon
                v-else-if="index === items.length - 1"
                name="md-keyboardarrowright-round"
            ></v-icon>
            <span v-else>
                {{ page.label }}
            </span>
        </v-button>
    </div>
</template>

<script setup>
defineProps({
    items: Array,
});
defineEmits(["pageChange"]);
</script>

<style lang="scss" scoped></style>
