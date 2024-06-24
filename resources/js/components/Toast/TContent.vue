<template>
    <div
        class="fixed z-[9999] max-w-[30rem] rounded-lg bg-white p-3 text-sm shadow-lg"
        :class="computedPosition"
        @mouseover="removeTimeout"
        @mouseleave="showToast"
    >
        <div class="flex items-center gap-3">
            <v-icon
                :name="computedType.icon"
                :class="computedType.textClass"
                scale="1.5"
            ></v-icon>
            <slot
                >Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint
                molestiae sit nihil, sunt cupiditate harum tempora aliquam iste
                reiciendis cumque necessitatibus praesentium dolores neque
                tenetur aut beatae minima. Fuga, expedita!</slot
            >
            <div v-if="closable">
                <v-icon
                    name="md-close-round"
                    @click="emit('close')"
                    class="cursor-pointer"
                ></v-icon>
            </div>
        </div>
        <div
            class="absolute inset-x-2 bottom-1 h-[.20rem] rounded-lg"
            :class="computedType.bgClass"
            :style="{ width: `${toastPercentage}%` }"
        ></div>
    </div>
</template>

<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from "vue";

const props = defineProps({
    timeout: { type: [String, Number], default: 4000 },
    position: {
        type: String,
        default: "top-right",
    },
    type: {
        type: String,
        default: "info",
    },
    closable: Boolean,
});
const emit = defineEmits(["close"]);

const timeoutId = ref(null);
const intervalId = ref(null);
const toastPercentage = ref(92);

const computedPosition = computed(() => {
    switch (props.position) {
        case "top-right": {
            return "top-2 right-2";
        }
        case "top-center": {
            return "top-2 right-[50%] translate-x-[-50%]";
        }
        case "top-left": {
            return "top-2 left-2";
        }
        case "left": {
            return "top-[50%] translate-y-[-50%] left-2";
        }
        case "right": {
            return "top-[50%] translate-y-[-50%] right-2";
        }
        case "center": {
            return "top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%]";
        }
        case "bottom-left": {
            return "left-2 bottom-2";
        }
        case "bottom-right": {
            return "right-2 bottom-2";
        }
        case "bottom-center": {
            return "left-[50%] translate-x-[-50%] bottom-2";
        }
    }
});

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
const showToast = () => {
    intervalId.value = setInterval(() => {
        toastPercentage.value -= 92 / (+props.timeout / 10);
    }, 10);

    timeoutId.value = setTimeout(() => {
        emit("close");
    }, +props.timeout);
};

const removeTimeout = () => {
    clearTimeout(timeoutId.value);
    clearInterval(intervalId.value);
    toastPercentage.value = 92;
};

onMounted(() => {
    showToast();
});

onBeforeUnmount(() => {
    removeTimeout();
});
</script>

<style lang="scss" scoped></style>
