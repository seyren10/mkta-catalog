<template>
    <v-sheet class="overflow-hidden px-0 py-0">
        <slot name="header" :tabs="tabs">
            <v-horizontal-scroller
                :items="tabs"
                no-indicator
                :activator="tabActivator"
                scrim
                :no-navigation="noNavigation"
            >
                <template #items="props">
                    <div class="bg-slate-200">
                        <ul
                            :class="`${props.class}  ${headerClass}`"
                            class="flex items-center gap-3 px-5 py-3"
                            ref="tabActivator"
                        >
                            <li
                                v-for="tab in props.items"
                                :key="tab"
                                class="max-w-[10rem] shrink-0"
                            >
                                <slot
                                    name="header.tab"
                                    :tab="tab.value"
                                    @click="model = tab.value"
                                    :isActive="tab === model.value"
                                >
                                    <button
                                        class="rounded-lg p-2 px-3 text-slate-400 duration-300 hover:bg-slate-300 hover:text-slate-500"
                                        :class="`${tab.value === model ? activeClass || 'bg-slate-200 font-medium' : ''}`"
                                        @click="model = tab.value"
                                    >
                                        {{ tab.title }}
                                    </button>
                                </slot>
                            </li>
                        </ul>
                    </div>
                </template>
            </v-horizontal-scroller>
            <!-- <ul
                :class="`flex items-center gap-3 bg-slate-200 px-5 py-3 ${headerClass}`"
            >
                
                <li v-for="tab in tabs" :key="tab.value">
                    <slot
                        name="header.tab"
                        :tab="tab"
                        @click="model = tab.value"
                        :isActive="tab.value === model"
                    >
                        <button
                            class="flex items-center rounded-lg p-2 px-3 text-slate-400 duration-300 hover:bg-slate-300 hover:text-slate-500"
                            :class="{
                                'bg-slate-300 font-medium text-slate-500':
                                    tab.value === model,
                            }"
                            @click="model = tab.value"
                        >
                            <v-icon
                                scale="1.3"
                                :name="tab.icon"
                                class="me-2"
                            ></v-icon>
                            <span>{{ tab.title }}</span>
                        </button>
                    </slot>
                </li>
            </ul> -->
        </slot>

        <div class="relative flex">
            <TransitionGroup
                enter-active-class="duration-300 ease-out "
                leave-active-class="duration-300 ease-out absolute"
                enter-from-class="opacity-0"
                leave-to-class="opacity-0"
            >
                <div
                    class="basis-full"
                    v-for="tab in tabs"
                    v-show="model === tab.value"
                    :key="tab.value"
                >
                    <slot :name="`content.${tab.value}`">
                        Lorem ipsum dolor sit, amet consectetur adipisicing
                        elit. Suscipit id odit ipsam excepturi dolore. Officiis,
                        eius alias error est corrupti incidunt soluta, provident
                        id molestiae corporis nulla cum voluptates ipsam!
                    </slot>
                </div>
            </TransitionGroup>
        </div>
    </v-sheet>
</template>

<script setup>
import { computed, ref } from "vue";

const props = defineProps({
    tabs: Array,
    headerClass: String,
    noNavigation: Boolean,
    activeClass: String,
});

const model = defineModel();
const tabActivator = ref(null);

if (!model.value) {
    model.value = props.tabs.at(0).value;
}

const titlesArray = computed(() => {
    return props.tabs.reduce((a, c) => {
        a.push(c.title);
        return a;
    }, []);
});
</script>

<style lang="scss" scoped></style>
