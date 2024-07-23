<template>
    <ul>
        <li v-for="(listItem, index) in JSON.parse(value)">
            <div class="group relative flex items-center gap-x-2 rounded-lg p-1 text-sm hover:bg-gray-50">
              <div>
                <v-icon :name="(listItem.icon) != '' ? listItem.icon  :  'la-cog-solid'" scale="1.3"></v-icon>
              </div>
              <div class="flex-auto">
                <p  class="block font-semibold text-gray-900">
                  {{ listItem.value }}
                  <span class="absolute inset-0"></span>
                </p>
                <p class="mt-1 text-gray-600">{{ listItem.title }}</p>
              </div>
            </div>
        </li>
    </ul>
</template>
<script setup>
const props = defineProps({
    value: {
        default: "",
        type: String,
    },
});
</script>
