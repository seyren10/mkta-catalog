<template>
    <v-card class="my-2">
        <template #title>
            <p class="text-xl font-bold">Catalog Recycle Bin</p>
        </template>
        <div>Temporary Storage allows to users to recover delete data.</div>
        <div class="mt-4 grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div>
                <v-card>
                    <template #title>
                        <p class="text-xl">
                            <v-icon
                                name="bi-cart4"
                                scale="1.5"
                                class="me-2"
                            />Products
                        </p></template
                    >
                    <hr class="my-2" />
                    Temporary Storage for deleted Product Item
                    <v-button
                        @click="()=>{
                            router.push({name:'dataRecycle_Products'})
                        }"
                        prepend-inner-icon="la-arrow-circle-right-solid"
                        class="ml-auto mt-6 border bg-green-500 text-white"
                    >
                        Proceed
                    </v-button>
                </v-card>
            </div>
        </div>
    </v-card>
</template>
<script setup>
import { onBeforeMount, inject, ref, watch } from "vue";

const router = inject("router");

</script>
