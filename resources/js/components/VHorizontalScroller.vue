<template>
    <div
        :style="{ maxHeight: `${maxWidth}px` }"
        class="snap-x snap-mandatory overflow-x-auto rounded-lg bg-white p-3"
    >
        <div class="grid auto-cols-[19%] grid-flow-col gap-3">
            <div
                class="relative snap-start overflow-hidden rounded-lg border p-2"
                v-for="(item, _) in items"
                :key="_"
            >
                <img
                    :src="item.image"
                    alt=""
                    class="aspect-square w-full object-cover"
                />
                <h1>{{ item.data.text }}</h1>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    maxWidth: {
        type: [String, Number],
        default: "500",
    },
    items: Array,
});
</script>

<style lang="scss" scoped></style>
