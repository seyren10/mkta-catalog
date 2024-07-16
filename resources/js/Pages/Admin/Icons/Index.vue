<template>
    <div class="pt-2">
        <div v-show="showHeader">
            <v-heading type="h2">
                <v-icon
                    v-if="$route.meta.redirectTo"
                    @click="
                        () => {
                            router.push({ name: $route.meta.redirectTo });
                        }
                    "
                    name="la-arrow-circle-left-solid"
                    scale="1.8"
                ></v-icon
                >{{ $route.meta.title }}</v-heading
            >
            <p>
                {{ $route.meta.description }}
            </p>
        </div>
        <div class="my-2">
            <v-text-field
                label="Search"
                prepend-inner-icon="la-search-solid"
                v-model="search"
            />
        </div>
        <div
            class="mb-2 mt-4 grid max-h-[75vh] grid-cols-6 gap-2 overflow-y-auto rounded-lg bg-white p-2"
        >
            <div
                v-for="icon in iconList.filter((element) => {
                    return element.toLowerCase().includes(search.toLowerCase());
                })"
                class="flex max-h-48 min-h-48 flex-col justify-between rounded-md p-2 hover:bg-gray-400"
            >
                <div class="flex flex-col items-center justify-center">
                    <v-icon
                        class="self-center"
                        scale="4"
                        :name="camelToKebabCase(icon)"
                    ></v-icon>
                    <p class="text-center">{{ camelToKebabCase(icon) }}</p>
                </div>
                <v-button
                    v-show="!isSelection"
                    @click="copyText(camelToKebabCase(icon))"
                    class="my-2 w-full bg-red-500 uppercase text-white"
                    >Copy</v-button
                >
                <v-button
                    v-show="isSelection"
                    @click="iconSelected(camelToKebabCase(icon))"
                    class="my-2 w-full bg-red-500 uppercase text-white"
                    >Select</v-button
                >
            </div>
        </div>
        
    </div>
</template>
<script setup>
//SECTION - required
import { ref, computed, inject } from "vue";
import { storeToRefs } from "pinia";

//!SECTION - imports
import iconList from "./icons.js";

//!SECTION - Props
const props = defineProps({
    showHeader: {
        default: true,
        type: Boolean,
    },
    isSelection: {
        default: false,
        type: Boolean,
    },
});

//!SECTION - Injects
const copyText = inject("copyText");

//!SECTION - Exceptions
const exceptions = ref({
    BiCart4: "bi-cart4",
});
const search = ref("");

//!SECTION - Methods
const camelToKebabCase = (inputStr) => {
    if (Object.keys(exceptions.value).includes(inputStr)) {
        return exceptions.value[inputStr];
    }
    return inputStr.replace(/[A-Z\d]/g, (match, offset) => {
        if (offset === 0) {
            return match.toLowerCase();
        } else {
            return "-" + match.toLowerCase();
        }
    });
};

//!SECTION - Dialog Functions & Variables
const emits = defineEmits(["submit", "close"]);

const iconSelected = (iconClass) => {
    emits("submit", iconClass);
    emits("close");
};
const cancel = () => {
    emits("close");
};
</script>
