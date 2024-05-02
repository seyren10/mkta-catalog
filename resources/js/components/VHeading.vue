<template>
    <component :is="type" :class="`font-serif ${getSize}  text-primary`">
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
                case "display":
                    return "text-[min(15vw,_5rem)] font-bold leading-none";
                case "h1":
                    return "text-[min(11vw,_3rem)] font-semibold leading-tight mb-5";
                case "h2":
                    return "text-[min(8vw,_2rem)] font-semibold leading-tight";
                case "h3":
                    return "text-[min(7.5vw,_1.7rem)] font-semibold leading-tight";

                default:
                    break;
            }
        },
    },
};
</script>

<style scoped></style>
