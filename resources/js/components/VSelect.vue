<template>
    <div class="relative">
        <VInputWrapper v-bind="props" v-slot="props">
            <button
                v-bind="{ ...$attrs, ...props }"
                @click="showSelection = !showSelection"
                @blur="showSelection = false"
            >
                <div class="flex">
                    <span>{{
                        modelValue
                            ? items.find((e) => e[value] === modelValue)[title]
                            : items[0][title]
                    }}</span>
                    <v-icon
                        name="la-arrows-alt-v-solid"
                        scale="1.2"
                        class="ml-auto cursor-pointer fill-stone-500"
                    ></v-icon>
                </div>
            </button>

            <Transition
                enter-from-class="opacity-0 translate-y-5"
                leave-to-class="opacity-0 translate-y-5"
                enter-active-class="duration-300 ease"
                leave-active-class="duration-300 ease"
            >
                <ul
                    class="absolute inset-x-0 z-10 overflow-hidden rounded-md border border-stone-400 bg-white"
                    :class="{
                        'bottom-[80%]': position === 'top',
                        'top-[110%]': position === 'bottom',
                    }"
                    v-show="showSelection"
                >
                    <li
                        v-for="item in items"
                        :key="item[title]"
                        class="p-3 duration-300 hover:bg-stone-400 hover:text-white"
                        @click="handleSelected(item[value] ?? item)"
                    >
                        <div class="flex items-center gap-2">
                            <v-icon name="la-check-solid"></v-icon>
                            <span>{{ item[title] }}</span>
                        </div>
                    </li>
                </ul>
            </Transition>
        </VInputWrapper>
    </div>
</template>

<script setup>
import { computed, ref } from "vue";
import VInputWrapper from "./base_components/VInputWrapper.vue";
import { useInput } from "@/composables/useInput";

defineOptions({
    inheritAttrs: false,
});

const props = defineProps({
    ...useInput(),
    position: { type: String, default: "top" },
    items: { type: Array },
    itemTitle: { type: String },
    itemValue: { type: String },
    modelValue: {},
});

const emit = defineEmits(["update:modelValue"]);

const showSelection = ref(false);

const title = computed(() => {
    return props.itemTitle ?? "title";
});

const value = computed(() => {
    return props.itemValue ?? "id";
});

const handleSelected = (value) => {
    emit("update:modelValue", value);
};
</script>

<style lang="scss" scoped></style>
