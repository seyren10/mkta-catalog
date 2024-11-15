<template>
    <section
        class="grid grid-rows-[min-content,_1fr] items-start gap-5 md:grid-cols-[min(18vw_+_1rem,15rem)_1fr]"
    >
        <aside
            class="sticky top-[11rem] row-span-2 hidden rounded-lg bg-white p-5 md:block"
        >
            <slot name="aside"> </slot>
        </aside>
        <!-- <div class="rounded-lg bg-white p-5">
            <slot name="top"></slot>
        </div> -->
        <div
            class="relative grid h-full auto-rows-min grid-cols-2 gap-5 rounded-lg bg-white p-5 md:grid-cols-3 lg:grid-cols-4"
        >
            <slot v-if="!loading">
                <div class="col-[1/-1] flex items-center justify-center gap-3">
                    <v-icon name="md-category-outlined"></v-icon>
                    <span> No items to show </span>
                </div>
            </slot>
            
            <div class="absolute inset-0 grid place-content-center" v-else>
                <VLoader scale="2"></VLoader>
            </div>
        </div>
        <div class="md:col-[2]">
            <slot name="footer"></slot>
        </div>
    </section>
</template>

<script setup>
import VLoader from "../../../../components/base_components/VLoader.vue";

defineProps({
    loading: Boolean,
});
</script>

<style lang="scss" scoped></style>
