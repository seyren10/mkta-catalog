<template>
    <section class="container my-8 space-y-5">
        <v-sheet class="grid gap-5 overflow-y-hidden md:grid-cols-2">
            <slot name="header"></slot>
        </v-sheet>

        <div class="grid lg:grid-cols-[min-content_,_1fr] gap-5">
            <div class="min-w-[15rem] text-slate-500 hidden lg:block">
                <slot name="aside"></slot>
            </div>

            <v-sheet class="overflow-hidden bg-transparent">
                <slot name="component"></slot>
            </v-sheet>
        </div>
    </section>
</template>

<script setup></script>

<style lang="scss" scoped></style>
