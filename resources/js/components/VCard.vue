<template>
    <div class="space-y-5 rounded-lg border bg-white" :class="densityValues">
        <slot name="header">
            <IconWrapper>
                <template #prepend>
                    <slot name="prepend">
                        <v-icon :name="prependIcon" scale="1.3"></v-icon>
                    </slot>
                </template>
                <template #append>
                    <slot name="append">
                        <v-icon :name="appendIcon" scale="1.3"></v-icon>
                    </slot>
                </template>
                <div>
                    <slot name="title" :title="title">
                        <h2 class="text-[1rem] font-bold tracking-wide">
                            {{ title }}
                        </h2>
                    </slot>
                    <slot name="subtitle" :subtitle="subtitle">
                        <p class="text-slate-400">{{ subtitle }}</p>
                    </slot>
                </div>
            </IconWrapper>
        </slot>

        <div class="">
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
            <slot name="action">
        </slot>

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
