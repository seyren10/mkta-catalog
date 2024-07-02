<template>
    <div class="flex items-center gap-2 text-slate-500">
        <div
            :class="`grid aspect-square h-4 cursor-pointer place-content-center rounded-md duration-300 ${isChecked ? 'bg-accent text-white' : 'bg-slate-200'}`"
            @click="handleCheck"
        >
            <v-icon v-if="isChecked" name="bi-check" scale="1"></v-icon>
        </div>
        <input
            type="checkbox"
            name=""
            :id="id"
            class="hidden h-0 w-0"
            v-model="model"
            :value="value"
        />
        <label :for="id" v-bind="$attrs" class="cursor-pointer">{{
            label
        }}</label>
    </div>
</template>

<script setup>
import { computed, ref } from "vue";

//defines
defineOptions({
    inheritAttrs: false,
});
const props = defineProps({
    label: String,
    value: String,
});
const model = defineModel();

//reactives
const id = ref(Math.random());

//computed
const hasMultipleValues = computed(() => {
    //check to see if it is a group checkbox(has multiple values on a single ref)
    return typeof model.value === "object";
});
const isChecked = computed(() => {
    if (hasMultipleValues.value) return model.value.includes(props.value);
    else return model.value;
});

//methods
const handleCheck = () => {
    if (hasMultipleValues) {
        //remove the value on the v-model when existed and add when not
        if (model.value?.includes(props.value))
            model.value = model.value.filter((e) => e !== props.value);
        else model.value.push(props.value);
    } else model.value = !model.value; // for v-model that has a single value
};
</script>

<style lang="scss" scoped></style>
