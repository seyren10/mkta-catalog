<template>
    <div
        class="mb-5 flex items-center justify-between rounded-lg bg-slate-100 p-2 text-xs text-slate-500"
    >
        <div class="flex items-center gap-4">
            <slot></slot>
            <v-checkbox
                class="text-primary"
                label="show selected files only"
                v-model="model"
            ></v-checkbox>
        </div>

        <div v-if="selectedItemsCount" class="flex items-center gap-2">
            <v-button
                class="rounded-full bg-accent text-white"
                icon="bi-check"
                @click="$emit('submit')"
            ></v-button>
            <v-button
                icon="md-close-round"
                icon-size="1"
                @click="$emit('clear')"
            ></v-button>
        </div>
    </div>
</template>

<script setup>
import { inject, ref, watch } from "vue";

const emits = defineEmits(["submit", "clear"]);
const model = defineModel({ default: false });
const selectedItemsCount = inject("selectedItemsCount", 0);
</script>

<style lang="scss" scoped></style>
