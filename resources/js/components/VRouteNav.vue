<template>
    <ul class="flex flex-wrap gap-3">
        <li
            v-for="item in items"
            class="grow overflow-hidden rounded-md duration-500 hover:bg-stone-200"
        >
            <div v-if="item.children && item.children.length" class="px-2">
                <div class="flex items-center gap-2">
                    <v-icon :name="item.icon" scale="1.3"></v-icon>
                    <p>{{ item.title }}</p>
                </div>

                <div class="grid justify-end gap-2">
                    <div v-for="child in item.children">
                        {{ child.title }}
                    </div>
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
