<template>
    <div class="rounded-lg border bg-white" :class="densityValues">
        <slot name="header"> </slot>
        <IconWrapper v-if="!$slots.header">
            <template #prepend>
                <slot name="prepend"></slot>
                <v-icon
                    :name="prependIcon"
                    v-if="!$slots.prepend"
                    scale="1.3"
                ></v-icon>
            </template>
            <template #append>
                <slot name="append"></slot>
                <v-icon
                    :name="appendIcon"
                    v-if="!$slots.append"
                    scale="1.3"
                ></v-icon>
            </template>
            <div>
                <h2 class="text-[1rem] font-bold tracking-wide">
                    {{ title }}
                </h2>
                <p class="text-slate-400">{{ subtitle }}</p>
            </div>
        </IconWrapper>

        <div class="my-5">
            <slot
                >Lorem ipsum dolor sit amet consectetur adipisicing elit. Id
                labore reiciendis hic nisi! Labore omnis quos quam natus
                veritatis. Maiores deserunt est facilis asperiores nesciunt,
                voluptate facere dolorum corrupti perspiciatis!</slot
            >
        </div>

        <footer
            class="flex items-center gap-4"
            :class="{
                'justify-end': actionAlign === 'end',
            }"
        >
            <slot name="action"> </slot>
        </footer>
    </div>
</template>

<script setup>
import { useDensity, useDensityValues } from "@/composables/useInput";
import IconWrapper from "@/components/base_components/VIconWrapper.vue";

const props = defineProps({
    ...useDensity(),
    prependIcon: String,
    appendIcon: String,
    title: String,
    subtitle: String,
    actionAlign: String,
});

const densityValues = useDensityValues(props.density);
</script>

<style lang="scss" scoped></style>
