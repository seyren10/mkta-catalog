<template>
    <VIconWrapper
        class="flex gap-2 rounded-md px-2 py-3"
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
                class: "bg-blue-200 text-blue-400",
                icon: "pr-info-circle",
            };
        }
        case "success": {
            return {
                class: "bg-green-200 text-green-400",
                icon: "pr-check-circle",
            };
        }
        case "error": {
            return {
                class: "bg-red-200 text-red-400",
                icon: "pr-times-circle",
            };
        }
        case "warning": {
            return {
                class: "bg-orange-200 text-orange-400",
                icon: "pr-exclamation-circle",
            };
        }
    }
});
</script>

<style lang="scss" scoped></style>
