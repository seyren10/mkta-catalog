<template>
    <div
        class="container relative my-10 grid min-h-[25vw] place-content-center overflow-hidden rounded-lg bg-primary"
    >
        <img
            src="/mk-images/astronaut-photo-op-removebg-preview.png"
            alt=""
            class="absolute bottom-0 left-0 max-w-[25rem] rotate-12 mix-blend-color-dodge"
        />
        <div class="text-center">
            <h1 class="mb-20 text-[min(7vw+1rem,_8rem)] text-slate-400">
                {{ code }}
            </h1>
            <p class="text-slate-200">{{ message }}</p>
            <div class="mx-auto mt-5 w-fit">
                <button
                    class="flex items-center rounded-lg bg-accent px-3 py-2 text-white"
                    @click="$router.push({ name: 'catalog', replace: true })"
                >
                    <v-icon name="md-keyboardarrowright-round"></v-icon>
                    <span> Go to Catalog</span>
                </button>
            </div>
        </div>
        <img
            src="/mk-images/space-shuttle-photo-op-removebg-preview.png"
            alt=""
            class="absolute right-0 top-0 max-w-[25rem] rotate-[210deg] mix-blend-color-dodge"
        />
    </div>
</template>

<script setup>
const props = defineProps({
    code: {
        type: Number,
        default: 404,
    },
    message: {
        type: String,
        default: "The page you're trying to access is not available",
    },
});
</script>

<style lang="scss" scoped></style>
