<template>
    <ul class="flex flex-wrap gap-1">
        <li
            v-for="item in items"
            class="grow overflow-hidden rounded-md duration-500 hover:bg-stone-200"
        >
            <div v-if="item.children && item.children.length" class="p-2">
                <div class="flex items-center gap-2">
                    <v-icon :name="item.icon" scale="1.3"></v-icon>
                    <p class="grow">{{ item.title }}</p>
                    <v-icon name="md-arrowdropdown-round" scale="1.3"></v-icon>
                </div>

                <div class="mt-1 grid gap-2 text-center text-[.8rem]">
                    <router-link
                        v-for="child in item.children"
                        :to="{ name: child.to }"
                        class="block rounded-md p-2"
                        active-class="bg-accent text-white"
                        :key="child.to"
                    >
                        {{ child.title }}
                    </router-link>
                </div>
            </div>
            <router-link
                v-else
                active-class="bg-accent text-white"
                class="flex items-center gap-2 p-2"
                :to="{ name: item.to }"
            >
                <v-icon :name="item.icon" scale="1.3"></v-icon>
                <span>{{ item.title }}</span>
            </router-link>
        </li>
    </ul>
</template>

<script setup>
const props = defineProps({
    items: {
        type: Array,
    },
});
</script>

<style lang="scss" scoped></style>
