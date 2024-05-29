<template>
    <div class="group relative overflow-hidden rounded-lg">
        <img
            :src="image"
            alt=""
            class="h-full w-full object-cover duration-300 group-hover:scale-105"
        />

        <slot
            name="overlay"
            :title="title"
            :subtitle="subtitle"
            v-if="!noOverlay"
            class="duration-500"
            :class="{
                'invisible translate-y-[100%] group-hover:visible group-hover:translate-y-[0]':
                    !appear,
            }"
        >
            <div
                class="absolute bottom-[.5rem] max-h-[80%] max-w-[96%] rounded-lg bg-black bg-opacity-30 p-3 text-white duration-500"
                :class="{
                    'left-[.5rem]': align === 'start',
                    'left-[50%] translate-x-[-50%]': align === 'center',
                    'right-[.5rem]': align === 'end',
                    'invisible translate-y-[100%] group-hover:visible group-hover:translate-y-[0]':
                        !appear,
                }"
            >
                <slot name="overlay-title" :title="title">
                    <h1 class="text-[1rem] font-medium">{{ title }}</h1>
                </slot>

                <slot name="overlay-subtitle" :subtitle="subtitle">
                    <p
                        class="mt-2 overflow-hidden whitespace-nowrap text-[.8rem] text-slate-300 [text-overflow:ellipsis]"
                    >
                        {{ subtitle }}
                    </p>
                </slot>
            </div>
        </slot>
    </div>
</template>

<script setup>
const props = defineProps({
    image: String,
    title: String,
    subtitle: String,
    align: {
        type: String,
        default: "start",
    },
    noOverlay: Boolean,
    appear: Boolean,
});
</script>

<style lang="scss" scoped></style>
