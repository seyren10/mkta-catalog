<template>
    <component
        :is="type"
        :class="`font-serif ${getSize} font-bold leading-tight text-primary`"
    >
        <slot></slot>
    </component>
</template>

<script>
export default {
    props: {
        type: {
            type: String,
            default: "h1",
        },
    },
    computed: {
        getSize() {
            switch (this.type) {
                case "h1":
                    return "text-[min(10vw,_3rem)] tracking-wide";
                case "h2":
                    return "text-[min(9vw,_2.5rem)]";
                case "h3":
                    return "text-[min(8vw,_2rem)]";

                default:
                    break;
            }
        },
    },
};
</script>

<style scoped></style>
