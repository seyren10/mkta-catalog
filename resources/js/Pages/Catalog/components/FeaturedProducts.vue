<template>
    <v-card class="relative border-none">
        <template #header>
            <div
                class="primary-gradient sticky top-[8.5rem] z-[10] flex items-center justify-center gap-3 rounded-lg py-5 text-white md:top-[9.75rem]"
            >
                <v-icon
                    :name="titleIcon"
                    scale="1.5"
                    class="fill-accent"
                ></v-icon>
                <h3 class="text-lg font-light uppercase tracking-wider">
                    {{ title }}
                </h3>
            </div>
        </template>

        <div
            class="grid grid-cols-2 items-start gap-3 sm:grid-cols-3 md:grid-cols-5"
        >
            <div
                v-for="item in items"
                :class="`overflow-hidden rounded-lg ${item.imageClass}`"
            >
                <v-text-on-image
                    v-bind="item.props"
                    :class="`aspect-square cursor-pointer rounded-none`"
                    :image="item.image"
                >
                    <template #overlay="overlayProps">
                        <slot name="overlay" :item="item"> </slot>
                        <div
                            v-bind="overlayProps"
                            class="absolute bottom-1 left-1 max-w-[96%] rounded-lg bg-black bg-opacity-50 p-3 text-white"
                        >
                            <h3 class="mb-1 font-medium">
                                {{ item.details.description }}
                            </h3>
                            <p class="text-[.8rem]">
                                Dimension :
                                <span class="text-slate-300">
                                    {{ item.details.dimension }}</span
                                >
                            </p>
                            <p class="text-[.8rem]">
                                Materials :
                                <span class="text-slate-300">
                                    {{ item.details.materials }}</span
                                >
                            </p>
                            <p class="text-[.8rem]">
                                Finish :
                                <span class="text-slate-300">
                                    {{ item.details.finish }}</span
                                >
                            </p>
                        </div>
                    </template>
                </v-text-on-image>
                <slot name="content" :item="item">
                    <div class="bg-slate-100 p-2">
                        <div class="line-clamp-2">
                            <slot
                                name="content.icon"
                                :item="{ ...item, class: 'float-left mr-2' }"
                            >
                                <div
                                    class="float-left mr-2 inline-flex items-center gap-1 rounded-lg bg-red-500 px-1 text-white"
                                >
                                    <v-icon
                                        name="ri-fire-line"
                                        scale=".8"
                                    ></v-icon>
                                    <span class="text-[.7rem]">{{
                                        item.sold
                                    }}</span>
                                </div>
                            </slot>
                            <h3
                                class="text-[min(1.5vw+.1rem,_.8rem)] font-bold [text-overflow:ellipsis]"
                            >
                                {{ item.details.description }}
                            </h3>
                        </div>
                        <div class="flex items-center justify-between">
                            <p class="mt-1 text-[.8rem] text-gray-400">
                                {{ item.details.dimension }}
                            </p>

                            <v-button
                                icon="la-heart"
                                iconSize="1"
                                class="text-accent"
                            ></v-button>
                        </div>
                    </div>
                </slot>
            </div>
        </div>
    </v-card>
</template>

<script setup>
const props = defineProps({
    items: Array,
    titleIcon: String,
    title: String,
    imageProps: Object,
});
</script>

<style lang="scss" scoped></style>
