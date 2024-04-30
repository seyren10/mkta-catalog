<template>
    <div class="absolute -z-10 flex gap-4 items-center">
        <img :src="svg" >
        </img>
        <slot></slot>
    </div>
</template>

<script setup>
    const props = defineProps({
        svg: {
            type: String
        }
    })
</script>

<style lang="scss" scoped>

</style>