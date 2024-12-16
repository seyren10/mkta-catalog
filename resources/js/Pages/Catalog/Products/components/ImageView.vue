<template>
    <div class="flex gap-3">
        <div
            class="scrollbar hidden max-h-[30rem] min-w-[4rem] max-w-[4rem] gap-5 self-center overflow-y-auto p-2 lg:grid"
        >
            <v-text-on-image
                v-for="(img, index) in productImages"
                :key="s3Thumbnail(img)"
                :image="img"
                no-overlay
                class="aspect-square rounded-lg border object-cover"
                :class="{
                    ' ring ring-accent ring-offset-4':
                        currentImageIndex === index,
                }"
                @click="currentImageIndex = index"
            />
            <!-- <img
                v-for="(img, index) in productImages"
                :key="img"
                :src="img"
                class="aspect-square rounded-lg object-cover"
                :class="{
                    ' ring ring-accent ring-offset-4':
                        currentImageIndex === index,
                }"
                @click="currentImageIndex = index"
            /> -->
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
</template>

<script setup>
import { inject } from "vue";

const productImages = inject("productImages");
const id = inject("id");
const currentImageIndex = inject("currentImageIndex");
const lightbox = inject("lightbox");

const s3Thumbnail = inject("s3Thumbnail");
</script>

<style lang="scss" scoped></style>
