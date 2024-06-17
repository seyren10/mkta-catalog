<template>
    <h3 class="p-3 text-[1rem] font-medium text-primary">Recently Viewed</h3>
    <ul class="grid gap-2 divide-slate-300">
        <li
            v-for="dum in dummy"
            class="flex cursor-pointer gap-3 rounded-lg p-2 hover:bg-slate-200"
            @click="
                $router.push({
                    name: 'product',
                    params: { id: dum.id },
                })
            "
        >
            <div class="aspect-square max-w-[5rem] p-1">
                <v-text-on-image
                    :image="dum.image"
                    class="h-full"
                    no-overlay
                ></v-text-on-image>
            </div>
            <div>
                <p class="line-clamp-2 h-min">
                    {{ dum.details.description }}
                </p>
                <span class="text-[.7rem] text-slate-400">{{
                    dum.details.dimension
                }}</span>
            </div>
        </li>
    </ul>
</template>

<script setup>
import { inject, computed } from "vue";

const productStore = inject("productStore");
//to be deleted FOR TESTING ONJLY
const dummy = computed(() => {
    return productStore.products.slice(10, 20);
});
</script>

<style lang="scss" scoped></style>
