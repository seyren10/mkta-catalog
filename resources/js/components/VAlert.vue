<template>
    <VIconWrapper
        class="flex gap-2 rounded-lg p-3"
        :class="alertType.class"
        :prepend-inner-icon="alertType.icon"
    >
        <!-- <template v-for="(_, slotName) in $slots" #[slotName]>
            <slot :name="slotName" />
        </template> -->
        <div>
            <slot></slot>
        </div>
    </VIconWrapper>
</template>

<script setup>
import { computed } from "vue";
import VIconWrapper from "./base_components/VIconWrapper.vue";

//props
const props = defineProps({
    type: {
        type: String,
        default: "info",
        validator: (value) => {
            return ["info", "success", "error", "warning"].includes(value);
        },
    },
});

//devired props
const alertType = computed(() => {
    switch (props.type) {
        case "info": {
            return {
                class: "bg-blue-200 bg-opacity-75 text-blue-500",
                icon: "pr-info-circle",
            };
        }
        case "success": {
            return {
                class: "bg-green-200 bg-opacity-75 text-green-500",
                icon: "pr-check-circle",
            };
        }
        case "error": {
            return {
                class: "bg-red-200 bg-opacity-75 text-red-500",
                icon: "pr-times-circle",
            };
        }
        case "warning": {
            return {
                class: "bg-orange-200 bg-opacity-75 text-orange-500",
                icon: "pr-exclamation-circle",
            };
        }
    }
});
</script>

<style lang="scss" scoped></style>
