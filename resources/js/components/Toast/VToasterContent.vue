<template>
    <div class="overflow-hidden rounded-lg text-sm shadow-sm">
        <div
            class="relative flex max-w-[20rem] items-start gap-3 border bg-white p-4"
            :class="computedType.textClass"
        >
            <v-icon :name="computedType.icon" class=""></v-icon>

            <router-link v-if="to" :to="to">
                <slot></slot>
            </router-link>

            <div class="grow self-center" v-else>
                <slot> </slot>
            </div>

            <div v-if="closable" class="text-primary">
                <v-button
                    icon="md-close-round"
                    icon-size=".9"
                    @click="deleteToast(id)"
                ></v-button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, inject } from "vue";

const props = defineProps({
    type: {
        type: String,
        default: "info",
    },
    closable: Boolean,
    to: {
        type: [String, Object],
        default: "",
    },
    id: String,
});

const deleteToast = inject("deleteToast");

const computedType = computed(() => {
    switch (props.type) {
        case "info": {
            return {
                icon: "pr-info-circle",
                textClass: "text-blue-500",
                bgClass: "bg-blue-500",
            };
        }
        case "success": {
            return {
                icon: "bi-check-circle",
                textClass: "text-green-500",
                bgClass: "bg-green-500",
            };
        }
        case "warning": {
            return {
                icon: "pr-exclamation-circle",
                textClass: "text-orange-500",
                bgClass: "bg-orange-500",
            };
        }
        case "danger": {
            return {
                icon: "pr-times-circle",
                textClass: "text-red-500",
                bgClass: "bg-red-500",
            };
        }
    }
});
</script>

<style lang="scss" scoped></style>
