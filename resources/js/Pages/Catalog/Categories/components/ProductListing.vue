<template>
    <section
        class="grid grid-rows-[min-content,_1fr] items-start gap-5 md:grid-cols-[min(18vw_+_1rem,15rem)_1fr]"
    >
        <aside
            class="sticky top-[11rem] row-span-2 hidden rounded-lg bg-white p-5 md:block"
        >
            <slot name="aside"> </slot>
        </aside>
        <div class="rounded-lg bg-white p-5">
            <slot name="top"></slot>
        </div>
        <div
            class="grid auto-rows-min grid-cols-2 gap-5 rounded-lg bg-white p-5 md:grid-cols-3 lg:grid-cols-2"
        >
            <slot>
                <div class="col-[1/-1] flex items-center gap-3 justify-center">
                    <v-icon name="md-category-outlined"></v-icon>
                    <span> No items to show </span>
                </div>
            </slot>
        </div>
    </section>
</template>

<script setup></script>

<style lang="scss" scoped></style>
