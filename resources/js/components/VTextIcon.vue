<template>
    <div>
        <div
            class="gap-2 rounded-md p-2"
            :class="{
                'flex items-center': !stacked,
                'grid text-center': stacked,
            }"
            v-for="item in items"
            :key="item.title"
        >
            <v-icon
                v-if="item.icon"
                :name="item.icon"
                scale="1.5"
                :class="{ 'mx-auto': stacked }"
            ></v-icon>
            <div>
                <div :class="titleClass" v-if="!$slots.title">
                    {{ item.title }}
                </div>
                <slot name="title" :item="item"></slot>
                <span :class="valueClass">{{ item.value }} </span>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    items: {
        type: Array,
    },
    titleClass: {
        type: String,
        default: "mb-0.5 font-medium",
    },
    valueClass: {
        type: String,
        default: "text-slate-500",
    },
    stacked: {
        type: Boolean,
        default: false,
    },
});
</script>

<style lang="scss" scoped></style>
