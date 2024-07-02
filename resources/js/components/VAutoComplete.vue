<template>
    <div class="relative">
        <VInputWrapper v-bind="{ ...props, densityValues }" v-slot="props">
            <input
             class="p-0 m-0 w-full"
                v-bind="{ ...$attrs, ...props }"
                @click="showSelection = !showSelection"
                @blur="showSelection = false"
                type="text"
                v-model="search"
            />
            <Transition
                enter-from-class="opacity-0 translate-y-5"
                leave-to-class="opacity-0 translate-y-5"
                enter-active-class="duration-300 ease"
                leave-active-class="duration-300 ease"
            >
                <ul
                    class="absolute inset-x-0 z-[2000] overflow-hidden rounded-lg border bg-white"
                    :class="{
                        'bottom-[110%]': position === 'top',
                        'top-[110%]': position === 'bottom',
                    }"
                    v-show="showSelection"
                >
                    <li></li>
                    <li
                        v-for="item in searchedItems"
                        :key="item[title]"
                        class="p-3 duration-300 hover:bg-slate-200"
                        @click="handleSelected(value ? item[value] : item)"
                    >
                        <div class="flex items-center gap-2">
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
import { MdPersonpinSharp } from "oh-vue-icons/icons";

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
const emit = defineEmits(["update:modelValue", "itemClick", "itemRemove"]);

const showSelection = ref(false);
const densityValues = useDensityValues(props.density);
const search = ref(null);

//computed
const title = computed(() => {
    return props.itemTitle ?? "title";
});

const value = computed(() => {
    return props.itemValue ?? "id";
});

//methods
const handleSelected = (value) => {
    emit("itemClick", value);
    emit("update:modelValue", value);
};

const searchedItems = computed(() => {
    if (search.value === null || String(search.value).trim() === "") {
        return props.items;
    }
    return props.items.filter((item) => {
        return String(item[props.itemTitle ?? "title"])
            .toLowerCase()
            .includes(search.value.toLowerCase());
    });
});
</script>

<style lang="scss" scoped></style>
