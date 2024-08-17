<template>
    <div class="col-span-full grid">
        <component
            :is="data.headingType ?? 'p'"
            :class="`${getHeadingClass()} ${getDataClassList()}`"
        >
            {{ data.text }}
        </component>
    </div>
</template>

<script setup>
const props = defineProps({
    data: Object,
});

function getDataClassList() {
    return Object.keys(props.data?.classList ?? {})
        .reduce((acc, cur) => {
            acc.push(props.data.classList[cur]);
            return acc;
        }, [])
        ?.join(" ");
}

function getHeadingClass() {
    switch (props.data.headingType) {
        case "h1":
            return "text-head leading-10";
        case "h2":
            return "text-[1.2rem]";
        case "h3":
            return "text-[1rem]";
    }
}
</script>

<style lang="scss" scoped></style>
