<template>
    <v-chip-group :items="model" @delete="handleRemoveItem">
        <template #append>
            <div class="relative grow">
                <input
                    type="text"
                    class="w-full outline-none"
                    @keydown.enter="handleAddItem"
                    v-model="input"
                    @focus="isInputFocus = true"
                    @blur="handleInputBlur"
                    ref="el"
                />
                <!-- #region overlay -->
                <div
                    v-if="isInputFocus"
                    class="absolute inset-x-0 top-[120%] z-[1000] overflow-hidden rounded-lg bg-white shadow-lg"
                >
                    <ul class="grid gap-2">
                        <li
                            v-for="item in searchSuggestions"
                            @click="handleAddSuggestion(item)"
                            class="cursor-pointer p-2 hover:bg-slate-200"
                        >
                            {{ item.value }}
                        </li>
                    </ul>
                </div>
                <!-- #endregion -->
            </div>
        </template>
    </v-chip-group>
</template>

<script setup>
import { computed, nextTick, provide, ref } from "vue";

const props = defineProps({
    clearable: Boolean,
    items: Array,
    appendable: Boolean,
});

const emits = defineEmits(["remove", "add"]);

const input = ref("");
const el = ref(null);
const isInputFocus = ref(false);
const isInsideOverlay = ref(false);
const model = defineModel({ default: [] });
const collection = ref([]);
const excludedSuggestions = ref([]);

const inputElement = ref(null);
const parentElement = ref(null);
const overlayElement = ref(null);
const overlayIndex = ref(0);

//provide
provide("clearable", props.clearable);

//watchers
watch(collection.value, (newValue) => {
    // console.log(newValue);
    // model.value = newValue;
});
//derives
const excludedSuggestionsComputed = computed(() => {
    if (!excludedSuggestions.value.length) return props.items;

    return props.items.filter((e) => {
        return !excludedSuggestions.value.find((f) => +f.id === +e.id);
    });
});

const searchSuggestions = computed(() => {
    if (input.value.trim() === "") return excludedSuggestionsComputed.value;

    return excludedSuggestionsComputed.value.filter((e) => {
        return e.value.toLowerCase().includes(input.value.toLowerCase());
    });
});

//methods
const handleAddItem = () => {
    collection.value.push({ id: Math.random(), value: input.value });
    input.value = "";
};

const handleRemoveItem = (item) => {
    const removeItem = collection.value.findIndex((e) => +e.id === +item.id);
    collection.value.splice(removeItem, 1);

    excludedSuggestions.value = excludedSuggestions.value.filter(
        (e) => +e.id !== +item.id,
    );
};

const handleAddSuggestion = (item) => {
    collection.value.push(item);
    excludedSuggestions.value.push(item);
};
const handleInputBlur = () => {
    setTimeout(() => {
        isInputFocus.value = false;
    }, 100);
};
</script>

<style lang="scss" scoped></style>
