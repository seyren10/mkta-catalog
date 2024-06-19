<template>
    <v-chip-group
        :items="model"
        @delete="handleRemoveItem"
        @click="handleFocusOnInput"
        ref="parentElement"
    >
        <template #append>
            <div class="relative grow">
                <input
                    type="text"
                    class="w-full outline-none"
                    @keydown.enter="handleAddItem"
                    @keydown="
                        (e) => {
                            if (e.key === 'Backspace' && input === '') {
                            }
                        }
                    "
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

//definitions
const props = defineProps({
    clearable: Boolean,
    items: Array,
    appendable: Boolean,

});

// const props.modelValue = defineModel('props.modelValue', { default: [], required : false });
const collections = ref(props.modelValue);
const input = ref("");
const el = ref(null);
const isInputFocus = ref(false);
const isInsideOverlay = ref(false);
const model = defineModel({ default: [] });
const excludedSuggestions = ref(JSON.parse(JSON.stringify(model.value)));

const emit = defineEmits(["removeItem", "appendItem"]);

//provide
provide("clearable", props.clearable);

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
    if (props.appendable) {
        collections.value.push({ id: Math.random(), value: input.value });
        // props.modelValue.value.push({ id: Math.random(), value: input.value });
        input.value = "";
    }
};

const handleRemoveItem = (item) => {
    if (!props.clearable) return;
    emits("remove", item);
    const removeItem = model.value.findIndex((e) => +e.id === +item.id);
    model.value.splice(removeItem, 1);

    const removeItem = props.modelValue.findIndex((e) => +e.id === +item.id);
    // props.modelValue.splice(removeItem, 1);
    collections.value.splice(removeItem, 1);
    excludedSuggestions.value = excludedSuggestions.value.filter(
        (e) => +e.id !== +item.id,
    );
};

const handleAddSuggestion = (item) => {
    model.value.push(item);
    excludedSuggestions.value.push(item);

    handleFocusOnInput();
};

const positionOverlay = () => {
    const parentRect =
        parentElement.value.chipgroupElement.getBoundingClientRect();

    overlayElement.value.style.top = parentRect.top + parentRect.height + "px";
    overlayElement.value.style.left = parentRect.left + "px";
    overlayElement.value.style.width = parentRect.width + "px";
};

const handleOverlayKeydown = (event) => {
    if (event.code === "ArrowUp") {
        if (overlayIndex.value > 0) {
            overlayIndex.value -= 1;
        } else
            overlayIndex.value = excludedSuggestionsComputed.value.length - 1;
    } else if (event.code === "ArrowDown") {
        if (overlayIndex.value < excludedSuggestionsComputed.value.length - 1)
            overlayIndex.value += 1;
        else overlayIndex.value = 0;
    } else if (event.code === "Backspace") {
        if (!input.value.length) {
            const item = model.value.at(model.value.length - 1);
            handleRemoveItem(item);
        }
    }
};

const handleInputFocus = async () => {
    isInputFocus.value = true;

    await nextTick();

    positionOverlay();

    window.addEventListener("scroll", positionOverlay);
    window.addEventListener("resize", positionOverlay);
};
const handleInputBlur = () => {
    setTimeout(() => {
        isInputFocus.value = false;
    }, 100);
};
</script>

<style lang="scss" scoped></style>
