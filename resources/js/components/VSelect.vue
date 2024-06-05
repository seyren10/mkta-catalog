<template>
    <div class="relative">
        <VInputWrapper v-bind="{ ...props, densityValues }" v-slot="props">
            <button
                v-bind="{ ...$attrs, ...props }"
                @click="showSelection = !showSelection"
                @blur="showSelection = false"
            >
                <div class="flex items-center">
                    <span>{{
                        modelValue
                            ? items.find((e) => e[value] === modelValue)[title]
                            : items[0][title]
                    }}</span>
                    <v-icon
                        name="md-arrowdropdown-round"
                        scale="1.5"
                        class="ml-auto cursor-pointer"
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
                    class="absolute inset-x-0 z-[2000] overflow-hidden rounded-lg border border-stone-400 bg-white"
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
                        :class="{ 'text-accent': modelValue === item[value] }"
                        @click="handleSelected(item[value] ?? item)"
                    >
                        <div class="flex items-center gap-2">
                            <v-icon
                                name="la-check-solid"
                                v-if="modelValue === item[value]"
                            ></v-icon>
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
import { useInput, useDensity, useDensityValues } from "@/composables/useInput";

defineOptions({
    inheritAttrs: false,
});

const props = defineProps({
    ...useInput(),
    ...useDensity(),
    position: { type: String, default: "top" },
    items: { type: Array },
    itemTitle: { type: String },
    itemValue: { type: String },
    modelValue: {},
});

const emit = defineEmits(["update:modelValue"]);

const showSelection = ref(false);
const densityValues = useDensityValues(props.density);

//computed
const title = computed(() => {
    return props.itemTitle ?? "title";
});

const value = computed(() => {
    return props.itemValue ?? "id";
});

//methods
const handleSelected = (value) => {
    emit("update:modelValue", value);
};
</script>

<style lang="scss" scoped></style>
