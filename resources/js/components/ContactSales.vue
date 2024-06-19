<template>
    <div class="grid space-y-5 text-sm md:grid-cols-2">
        <p class="col-span-2">
            Please contact us via email, and we will respond at our earliest
            convenience. You may use the form provided below or send a direct
            email to
            <a href="mailto:info@us-cg.dk" class="text-accent">info@us-cg.dk</a>
        </p>
        <section>
            <v-text-field
                label="Full Name"
                :rules="['required']"
                ref="comp"
            ></v-text-field>
        </section>
        <section></section>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";

const comp = ref(null);

onMounted(() => {
    console.dir(comp);
});
</script>

<style lang="scss" scoped></style>
