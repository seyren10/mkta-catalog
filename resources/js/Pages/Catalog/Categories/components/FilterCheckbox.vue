<template>
    <div class="flex w-min items-center cursor-pointer gap-2 text-slate-500" @click="$emit('check', value)">
        <div
            :class="`grid aspect-square h-4  place-content-center rounded-md duration-300 ${checked ? 'bg-accent text-white' : 'bg-slate-200'}`"
            
        >
            <v-icon v-if="checked" name="bi-check" scale="1"></v-icon>
        </div>
        <input
            type="checkbox"
            :id="id"
            class="hidden h-0 w-0"
            @change="$emit('check', value)"
        />
        <label :for="id" v-bind="$attrs" class="w-fit cursor-pointer">{{ label }}</label>
    </div>
</template>

<script setup>
import { ref } from "vue";

//defines
defineOptions({
    inheritAttrs: false,
});

const props = defineProps({
    label: String,
    value: Object,
    checked: {},
});

const emits = defineEmits(["check"]);

//reactives
const id = ref(Math.random());
</script>

<style lang="scss" scoped></style>
