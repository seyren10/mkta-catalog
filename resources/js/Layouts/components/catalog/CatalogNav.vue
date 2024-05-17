<template>
    <nav class="bg-primary">
        <div class="container pb-1">
            <div>header content</div>
            <div class="flex items-center justify-between gap-5">
                <img
                    src="/MKLogo-White.svg"
                    alt=""
                    class="mr-3 hidden max-w-[6rem] sm:block"
                />

                <div class="inline-flex grow items-center gap-5 sm:grow-0">
                    <div
                        class="flex grow overflow-hidden rounded-md bg-white duration-500 has-[:focus]:ring-4 has-[:focus]:ring-accent sm:min-w-[25rem]"
                    >
                        <div class="my-auto grow pt-1">
                            <textarea
                                class="w-full resize-none px-4 text-primary outline-none"
                                rows="1"
                                placeholder="Search for products"
                            />
                        </div>
                        <v-button class="rounded-none bg-accent text-white">
                            <div class="px-2">
                                <v-icon
                                    name="la-search-solid"
                                    scale="1"
                                ></v-icon>
                            </div>
                        </v-button>
                    </div>
                    <div class="cursor-pointer">
                        <v-tooltip>Wishlist</v-tooltip>
                        <v-icon name="la-heart" scale="1.5" class="fill-accent">
                        </v-icon>
                    </div>
                </div>
            </div>
            <div class="mb-2 mt-4 flex items-center gap-4">
                <v-menu class="p-3">
                    <template #activator="props">
                        <v-button
                            v-bind="props"
                            ref="activator"
                            class="text-[.8rem]"
                            append-inner-icon="md-keyboardarrowdown-round"
                            >Categories</v-button
                        >
                    </template>
                    <div class="grid grid-cols-5 gap-3">
                        <div>
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Itaque explicabo tempore iusto minus quo.
                            Sequi ducimus eveniet magni voluptate? Repudiandae,
                            ipsa incidunt porro doloribus a vero magnam
                            asperiores eos soluta!
                        </div>
                        <div>
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Itaque explicabo tempore iusto minus quo.
                            Sequi ducimus eveniet magni voluptate? Repudiandae,
                            ipsa incidunt porro doloribus a vero magnam
                            asperiores eos soluta!
                        </div>
                        <div>
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Itaque explicabo tempore iusto minus quo.
                            Sequi ducimus eveniet magni voluptate? Repudiandae,
                            ipsa incidunt porro doloribus a vero magnam
                            asperiores eos soluta!
                        </div>
                        <div>
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Itaque explicabo tempore iusto minus quo.
                            Sequi ducimus eveniet magni voluptate? Repudiandae,
                            ipsa incidunt porro doloribus a vero magnam
                            asperiores eos soluta!
                        </div>
                        <div>
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Itaque explicabo tempore iusto minus quo.
                            Sequi ducimus eveniet magni voluptate? Repudiandae,
                            ipsa incidunt porro doloribus a vero magnam
                            asperiores eos soluta!
                        </div>
                    </div>
                </v-menu>
                <div
                    class="flex gap-3 *:rounded-md *:bg-slate-600 *:text-[.8rem] *:text-slate-300"
                >
                    <v-button density="compact">Halloween</v-button>
                    <v-button density="compact">Summer</v-button>
                    <v-button density="compact">Winter</v-button>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup></script>

<style lang="scss" scoped></style>
