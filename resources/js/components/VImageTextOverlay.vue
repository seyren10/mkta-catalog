<template>
    <div
        class="group relative overflow-hidden"
        :class="{
            'before:absolute before:inset-0 before:z-10 before:backdrop-saturate-50 before:transition-[backdrop-filter] before:duration-500 hover:before:backdrop-saturate-100 hover:before:transition-[backdrop-filter]':
                !appear && !noFilter,
        }"
    >
        <img
            :src="src"
            :alt="src"
            class="h-full w-full object-cover transition-all duration-500 group-hover:scale-105"
        />
        <div
            v-if="!noPopup"
            class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-primary to-transparent p-5 text-white"
            :class="{
                'translate-y-full opacity-0 transition-transform duration-500 ease-in-out group-hover:translate-y-0 group-hover:opacity-100':
                    !appear,
            }"
        >
            <v-heading
                type="h3"
                class="mb-2 flex items-center font-bold text-white"
            >
                <span>{{ title }}</span>
                <v-icon
                    name="bi-heart-fill"
                    scale="1.3"
                    class="ml-auto fill-accent"
                ></v-icon
            ></v-heading>

            <div>
                <slot />
            </div>
            <div class="mt-4"></div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    title: { type: String, default: "No Title" },
    src: { type: String },
    appear: { type: Boolean },
    noPopup: { type: Boolean },
    noFilter: { type: Boolean },
});
</script>

<style lang="scss" scoped></style>
