<template>
    <div>
        <slot name="activator"></slot>

        <template v-if="!$slots.activator">
            <v-button>Open Dialog</v-button>
        </template>

        <Teleport to="body" v-if="modelValue">
            <div class="fixed inset-0 z-[3000] bg-black opacity-20"></div>
            <div
                class="fixed inset-0 z-[3001] grid animate-appear place-items-center backdrop:bg-gray-300"
            >
                <div
                    v-bind="$attrs"
                    class="grid overflow-hidden rounded-md border bg-white"
                    :style="maxWidth ? `max-width: ${maxWidth}px` : ''"
                    ref="clossss"
                >
                    <!-- TOOLBAR -->
                    <div
                        class="flex items-center justify-between bg-stone-200 p-2"
                    >
                        <slot name="title"></slot>
                        <v-heading
                            type="h3"
                            v-if="!$slots.title"
                            class="font-normal"
                            >{{ title }}</v-heading
                        >

                        <v-button
                            icon="md-close-round"
                            @click="$emit('update:modelValue', false)"
                        ></v-button>
                    </div>
                    <!-- /TOOLBAR -->

                    <div class="p-3">
                        <slot>
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Ducimus unde quasi pariatur! Incidunt laborum
                            laboriosam consequatur. Eaque, voluptate! Officia id
                            vitae praesentium ipsa voluptates quibusdam
                            similique eum eos nihil possimus..</slot
                        >
                    </div>
                </div>
            </div>
        </Teleport>
    </div>
</template>

<script setup>
import { onMounted, ref, onUpdated } from "vue";

const props = defineProps(["modelValue", "maxWidth", "title", "persistent"]);
const emits = defineEmits(["update:modelValue"]);
const clossss = ref(null);

const closeCallback = (e, el) => {
    if (el.contains(e.target)) {
        console.log("insdide");
    } else console.log("outisde");
};

defineOptions({
    inheritAttrs: false,
});

onMounted(() => {
    console.log(clossss.value);
});

onUpdated(() => {
    if (props.modelValue) {
        document
            .querySelector("body")
            .classList.add("h-full", "overflow-hidden");
    } else {
        document
            .querySelector("body")
            .classList.remove("h-full", "overflow-hidden");
    }
});
</script>

<style lang="scss" scoped></style>
