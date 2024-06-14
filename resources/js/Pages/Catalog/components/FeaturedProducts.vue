<template>
    <v-card class="relative border-none">
        <template #header>
            <div
                class="sticky top-[10rem] z-[10] flex items-center justify-center gap-3 rounded-lg bg-white py-5 text-primary md:top-[9.75rem]"
            >
                <v-icon
                    :name="titleIcon"
                    scale="1.5"
                    class="fill-accent"
                ></v-icon>
                <h3 class="text-lg font-light uppercase tracking-wider">
                    {{ title }}
                </h3>
            </div>
        </template>

        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-6">
            <div
                v-for="item in items"
                :class="`overflow-hidden rounded-lg ${item.imageClass}`"
            >
                <Product :item="item" class="bg-slate-1000">
                    <template
                        v-for="(_, slotName) in $slots"
                        #[slotName]="{ item: props }"
                    >
                        <slot :name="slotName" :item="props" />
                    </template>
                </Product>
            </div>
        </div>
    </v-card>
</template>

<script setup>
import Product from "../../../components/Product.vue";

const props = defineProps({
    items: Array,
    titleIcon: String,
    title: String,
    imageProps: Object,
});

//functions
const handleIntersect = (entry) => {
    console.log(entry.target);
};
</script>

<style lang="scss" scoped></style>
