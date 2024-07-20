<template>
    <div>
        <span class="my-6 text-[.8rem] text-slate-400">{{ title }}</span>
        <ul class="grid max-h-[80vh] flex-wrap overflow-auto">
            <li
                v-for="item in items"
                class="overflow-hidden rounded-lg duration-500 hover:bg-stone-200"
            >
                <div v-if="item.children && item.children.length" class="p-2">
                    <div class="flex items-center gap-2">
                        <v-icon :name="item.icon" scale="1.3"></v-icon>
                        <p class="grow">{{ item.title }}</p>
                        <v-icon
                            name="md-arrowdropdown-round"
                            scale="1.3"
                        ></v-icon>
                    </div>

                    <div class="mt-1 grid gap-2 text-center text-[.8rem]">
                        <router-link
                            v-for="child in item.children"
                            :to="{ name: child.to }"
                            class="block rounded-lg p-2"
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
                    class="flex items-center gap-3 p-2"
                    :to="{ name: item.to }"
                >
                    <template #default="{ isActive }">
                        <v-icon
                            :name="item.icon"
                            scale=".8"
                            :color="isActive ? '#fff' : '#64748b'"
                        ></v-icon>
                        <span>{{ item.title }}</span>
                    </template>
                </router-link>
            </li>
        </ul>
    </div>
</template>

<script setup>
const props = defineProps({
    title: {
        default: null,
    },
    items: {
        type: Array,
    },
});
</script>

<style lang="scss" scoped></style>
