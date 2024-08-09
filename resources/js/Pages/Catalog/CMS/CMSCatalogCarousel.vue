<template>
    <div class="col-span-full">
        <v-horizontal-scroller :items="images" item-size="100%" auto-scroll>
            <template #default="{ item }">
                <v-text-on-image
                    class="aspect-[3/1]"
                    v-if="!item?.link"
                    :image="item.filename"
                    no-overlay
                ></v-text-on-image>
                <router-link v-else :to="item.path">
                    <v-text-on-image
                        class="aspect-[3/1]"
                        :image="item.filename"
                        no-overlay
                    ></v-text-on-image>
                </router-link>
            </template>
        </v-horizontal-scroller>
    </div>
</template>

<script setup>
import { computed, inject } from "vue";

const props = defineProps({
    data: Array,
});

const s3 = inject("s3");

const images = computed(() => {
    return props.data.map((d) => {
        return {
            ...d,
            filename: s3(d.filename),
        };
    });
});
</script>

<style lang="scss" scoped></style>
