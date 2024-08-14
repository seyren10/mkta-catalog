<template>
    <div>
        <v-checkbox label="add text overlay" v-model="hasOverlay"></v-checkbox>

        <div v-if="hasOverlay">
            <v-text-field label="Heading" v-model="heading"></v-text-field>
            <v-text-field label="Paragraph" v-model="paragraph"></v-text-field>
        </div>
    </div>
</template>

<script setup>
const hasOverlay = defineModel("overlay");
const heading = defineModel("heading");
const paragraph = defineModel("paragraph");
</script>

<style lang="scss" scoped></style>
