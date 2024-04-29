<template>
    <component
        :is="type"
        :class="`font-serif ${getSize}  leading-tight text-primary`"
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
                    return "text-[min(15vw,_5rem)] font-bold";
                case "h2":
                    return "text-[min(11vw,_3rem)] font-semibold";
                case "h3":
                    return "text-[min(8vw,_2rem)] font-semibold";

                default:
                    break;
            }
        },
    },
};
</script>

<style scoped></style>
