<template>
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
            v-model="currentImageIndex"
            :key="id"
        >
            <template #default="{ item }">
                <v-text-on-image
                    :image="item"
                    no-overlay
                    class="aspect-square cursor-zoom-in"
                    @click="lightbox = true"
                ></v-text-on-image>
            </template>
        </v-horizontal-scroller>
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
