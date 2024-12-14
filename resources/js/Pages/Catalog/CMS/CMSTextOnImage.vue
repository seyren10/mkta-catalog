<template>
    <div class="col-span-full ">
        <v-text-on-image
            :class="`${data.aspectRatio}`"
            v-if="!data?.link"
            :image="s3Thumbnail(data.filename)"
            :no-overlay="!data.overlay"
            :title="data.heading"
            :subtitle="data.paragraph"
        ></v-text-on-image>
        <router-link v-else :to="data.path">
            <v-text-on-image
                :class="`${data.aspectRatio}`"
                :image="s3Thumbnail(data.filename)"
                :no-overlay="!data.overlay"
                :title="data.heading"
                :subtitle="data.paragraph"
            ></v-text-on-image>
        </router-link>
    </div>
</template>

<script setup>
import { inject } from "vue";

const props = defineProps({
    data: Object,
});

const s3Thumbnail = inject("s3Thumbnail");
</script>

<style lang="scss" scoped></style>
