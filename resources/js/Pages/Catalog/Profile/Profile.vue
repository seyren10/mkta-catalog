<template>
    <section class="container mt-10">
        <div class="grid gap-5 md:grid-cols-[auto,_1fr]">
            <ProfileInfo
                class="rounded-lg border bg-white p-6 md:h-[min(65vh+_1rem,_50rem)]"
            ></ProfileInfo>
            <div
                class="grid place-content-center rounded-lg border bg-white p-6"
            >
                <div class="text-center">
                    <v-icon
                        name="la-meh-blank"
                        scale="2"
                        class="text-slate-300"
                    ></v-icon>
                    <p>Additional content coming soon...</p>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import ProfileInfo from "./ProfileInfo.vue";
</script>

<style lang="scss" scoped></style>
