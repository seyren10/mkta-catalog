<template>
    <div class="container my-8">
        <v-carousel-2
            :items="[
                {
                    img: '/carousel-test/1.jpg',
                    title: 'Main Attraction',
                    description: 'lorem',
                },
                {
                    img: '/carousel-test/2.jpg',
                    title: 'Plausible Effect',
                    description: 'if you can read this, youre gay',
                },
                {
                    img: '/carousel-test/3.jpg',
                    title: 'Exaggerated Hamster',
                    description: 'none of this is true, we are just...',
                },
                {
                    img: '/carousel-test/4.jpg',
                    title: 'Equilibrium McDonalds',
                    description: 'Just dont.',
                },
                {
                    img: '/carousel-test/5.jpg',
                    title: 'Think of Laura',
                    description:
                        'laught, dont cry, i know she want it that way',
                },
            ]"
        >
        </v-carousel-2>
        <v-card density="comfortable">
            <template #header>
                <header
                    class="grid min-h-[10rem] rounded-lg bg-[url('/mk-images/inlitefi.jpg')] bg-cover bg-center bg-no-repeat text-white"
                >
                    <div class="self-end p-4">
                        <h2 class="text-[1.3rem] font-medium tracking-wide">
                            A Heading with background Image
                        </h2>
                        <p class="font-light text-slate-200">
                            If you can read this, you are gay.
                        </p>
                    </div>
                </header>
            </template>
            <div>
                We are the champion. Lorem, ipsum dolor sit amet consectetur
                adipisicing elit. Doloribus earum laudantium soluta eveniet, id
                dolorum praesentium quia, facilis sit, ab et beatae optio est
                officiis exercitationem ut tenetur? Nam, ea.
            </div>
            <template #action>
                <v-button
                    class="text-accent"
                    outlined
                    prepend-inner-icon="pr-send"
                    icon-size="1"
                    >See More</v-button
                >
            </template>
        </v-card>
        <v-text-field v-model="search"> </v-text-field>
        <v-data-table
            :items="items"
            :search="search"
            class="my-3"
            striped
            density="comfortable"
        ></v-data-table>
    </div>
</template>

<script setup>
import { ref } from "vue";

const search = ref("");
const items = ref(null);

await fetch("https://jsonplaceholder.typicode.com/todos")
    .then((res) => res.json())
    .then((json) => (items.value = json));
</script>

<style lang="scss" scoped></style>
