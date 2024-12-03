<template>
    <div class="space-x-2">
        <button class="rounded-lg border px-[.31rem] py-[.18rem]">
            <v-icon
                name="md-keyboardarrowup-round"
                scale=".8"
                @click="$emit('up')"
            ></v-icon>
        </button>
        <button class="rounded-lg border px-[.31rem] py-[.18rem]">
            <v-icon
                name="md-keyboardarrowdown-round"
                scale=".8"
                @click="$emit('down')"
            ></v-icon>
        </button>
    </div>
</template>

<script setup>
const emit = defineEmits(["up", "down"]);
</script>

<style lang="scss" scoped></style>
