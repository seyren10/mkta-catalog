<template>
    <div class="mb-6 px-3">
        <h2
            class="mb-2 w-full border-b-2 py-2 text-[1.5rem] font-bold tracking-wide"
        >
            Technical Information
        </h2>
        <div class="mb-4 flex w-fit gap-2">
            <v-button
                class="text-xs"
                @click="conversion = 'metric'"
                :class="{
                    'bg-accent text-white': conversion === 'metric',
                }"
                >Metric</v-button
            >
            <v-button
                class="text-xs"
                :class="{
                    'bg-accent text-white': conversion !== 'metric',
                }"
                @click="conversion = 'imperial'"
                >Imperial</v-button
            >
        </div>
        <ul class="grid gap-3 lg:grid-cols-2">
            <li
                v-for="(detail, key) in product.details"
                :key="key"
                class="flex gap-3"
            >
                <span class="min-w-[5rem] capitalize text-slate-400"
                    >{{ key }}:</span
                >
                <span v-html="detail"> </span>
            </li>
        </ul>
        <div class="rounded-md bg-gray-50 p-2 text-xs mt-4 text-slate-400">
            <v-icon class="me-2" name="pr-info-circle"></v-icon>
            While we make every effort to ensure accuracy, actual product
            dimensions may vary slightly due to manufacturing processes or
            measurement techniques.
        </div>
    </div>
</template>
<script setup>
import { inject, ref, computed } from "vue";

const conversion = ref("metric");
const injectedProduct = inject("product");

const IMPERIAL_lENGTH = 2.54;
const IMPERIAL_POUND = 2.205;

const product = computed(() => {
    return {
        ...injectedProduct.value,
        details: {
            code: injectedProduct.value.id,
            height: `${conversion.value === "metric" ? injectedProduct.value.dimension_height : (+injectedProduct.value.dimension_height / IMPERIAL_lENGTH).toFixed(2)} <span class='text-slate-400'>${conversion.value === "metric" ? "cm" : "inch"}</span>`,
            length: `${conversion.value === "metric" ? injectedProduct.value.dimension_length : (+injectedProduct.value.dimension_length / IMPERIAL_lENGTH).toFixed(2)} <span class='text-slate-400'>${conversion.value === "metric" ? "cm" : "inch"}</span>`,
            width: `${conversion.value === "metric" ? injectedProduct.value.dimension_width : (+injectedProduct.value.dimension_width / IMPERIAL_lENGTH).toFixed(2)} <span class='text-slate-400'>${conversion.value === "metric" ? "cm" : "inch"}</span>`,
            volume: `${injectedProduct.value.volume} <span class='text-slate-400'> m<sup>3</sup></span>`,
            "weight(gross)": `${conversion.value === "metric" ? injectedProduct.value.weight_gross : (+injectedProduct.value.weight_gross * IMPERIAL_POUND).toFixed(2)} <span class='text-slate-400'>${conversion.value === "metric" ? "kg" : "lbs"}</span>`,
            "weight(net)": `${conversion.value === "metric" ? injectedProduct.value.weight_net : (+injectedProduct.value.weight_net * IMPERIAL_POUND).toFixed(2)} <span class='text-slate-400'>${conversion.value === "metric" ? "kg" : "lbs"}</span>`,
        },
    };
});
</script>
