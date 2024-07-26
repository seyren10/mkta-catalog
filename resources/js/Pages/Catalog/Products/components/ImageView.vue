<template>
    <div class="grid">
        <div class="items flex gap-3">
            <div
                class="scrollbar hidden max-h-[30rem] max-w-[5rem] auto-rows-[min-content] gap-5 self-center overflow-y-auto p-2 lg:grid"
            >
                <img
                    v-for="(img, index) in productImages"
                    :key="img"
                    :src="img"
                    class="aspect-square rounded-lg object-cover"
                    :class="{
                        ' ring ring-accent ring-offset-4':
                            currentImageIndex === index,
                    }"
                    @click="currentImageIndex = index"
                />
            </div>
            <v-horizontal-scroller
                :items="productImages"
                item-size="100%"
                no-indicator
                scrim
                v-model="currentImageIndex"
                :key="id"
            >
                <template #default="{ item }">
                    <v-text-on-image
                        :image="item"
                        class="aspect-square cursor-zoom-in"
                        @click="lightbox = true"
                        no-overlay
                    >
                    </v-text-on-image>
                </template>
            </v-horizontal-scroller>
        </div>
        <div class="py-2 text-justify">
            <v-icon class="me-2" name="pr-info-circle"></v-icon>Due to
            variations in monitor settings, screen resolutions, and lighting
            conditions, the actual color of the product may differ slightly from
            what appears on your device. We strive to represent colors as
            accurately as possible, but we cannot guarantee an exact match
        </div>
    </div>
</template>

<script setup>
import { inject } from "vue";

const productImages = inject("productImages");
const id = inject("id");
const currentImageIndex = inject("currentImageIndex");
const lightbox = inject("lightbox");
</script>

<style lang="scss" scoped></style>
