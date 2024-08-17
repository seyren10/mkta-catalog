<template>
    <div class="col-span-full ">
        <v-text-on-image
            :class="`${data.aspectRatio}`"
            v-if="!data?.link"
            :image="s3(data.filename)"
            :no-overlay="!data.overlay"
            :title="data.heading"
            :subtitle="data.paragraph"
        ></v-text-on-image>
        <router-link v-else :to="data.path">
            <v-text-on-image
                :class="`${data.aspectRatio}`"
                :image="s3(data.filename)"
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

const s3 = inject("s3");
</script>

<style lang="scss" scoped></style>
