<script setup>
const props = defineProps({
    icon: String,
    selected: Boolean,
});
</script>

<template>
    <li>
        <button
            class="flex items-center rounded-md px-3 py-1.5 uppercase text-gray-400 hover:bg-white/95 gap-1"
            :class="{ 'bg-white text-primary': selected }"
            icon-size=".8"
        >
            <v-icon :name="icon" v-if="icon"></v-icon>
            <slot />
        </button>
    </li>
</template>

<style lang="scss" scoped></style>
