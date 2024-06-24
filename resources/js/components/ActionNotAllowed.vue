<template>
    <div
        class="relative isolate grid min-h-screen place-content-center overflow-hidden bg-primary"
    >
        <img
            src="/mk-images/astronaut-photo-op-removebg-preview.png"
            alt="astronaut"
            class="top-0] absolute z-10 rotate-12 opacity-30 mix-blend-color-dodge"
        />
        <img
            src="/mk-images/space-shuttle-photo-op-removebg-preview.png"
            alt="astronaut"
            class="absolute right-0 top-[50%] -rotate-12 opacity-30 mix-blend-color-dodge"
        />

        <div class="relative text-center text-white">
            <img src="/MKLogo-White.svg" alt="" class="mx-auto max-w-[10rem]" />
            <h1
                class="font-serif text-[max(15vw_+_1rem_,_8rem)] text-slate-400"
            >
                {{ code.code }}
            </h1>
            <p>
                {{ code.message }}
            </p>
            <v-button
                class="mx-auto mt-5 bg-accent"
                prepend-inner-icon="la-arrow-circle-right-solid"
                @click="$router.push({ name: 'index' })"
                >Go to main page</v-button
            >
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const code = computed(() => {
    switch (route.query.type) {
        case "notFound": {
            return {
                code: "404",
                message: ` The page you are looking for might be unavailable or is temporalily
                removed.`,
            };
        }
        case "unAuthorized": {
            return {
                code: "401",
                message: ` You have attempted to access a page for which you are not authorized.`,
            };
        }
    }
});
</script>

<style lang="scss" scoped></style>
