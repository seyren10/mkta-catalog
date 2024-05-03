<template>
    <div>
        <div class="grid grid-cols-2">
            <v-text-field
                prepend-inner-icon="la-heart"
                label="Email"
                v-model="email"
            ></v-text-field>
            <v-textarea prepend-inner-icon="la-heart" label="Comment">
            </v-textarea>
            <v-select
                label="Region"
                :items="regions"
                item-title="region"
                prepend-inner-icon="la-heart"
                v-model="region"
            ></v-select>
        </div>
        <div>
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Omnis
            magnam quam sequi corrupti in, cupiditate sapiente voluptas, at
            consectetur, ad commodi recusandae necessitatibus aliquam facilis?
            Minima quam molestias labore accusantium.
        </div>
    </div>
</template>

<script setup>
import { computed, ref } from "vue";

const email = ref("");
const region = ref(null);

const regions = computed(() => {
    return [
        { id: "as", region: "Asia" },
        { id: "af", region: "Africa" },
        { id: "au", region: "Australia" },
        { id: "eu", region: "Europe" },
        { id: "na", region: "North America" },
        { id: "sa", region: "South America" },
    ];
});
</script>

<style scoped></style>
