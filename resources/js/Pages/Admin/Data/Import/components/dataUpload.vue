<template>
    <v-card class="">
        <template #title>
            <p class="text-xl font-bold">{{ pageTitle }}</p>
        </template>
        <div class="border-b border-t p-2">
            <ul class="grid grid-cols-1 gap-6">
                <li v-if="templateURL != null">
                    Get the template by clicking
                    <a
                        :href="templateURL"
                        target="_blank"
                        class="rounded-lg bg-red-500 px-2 text-white underline"
                        >here</a
                    >
                    <ul
                        class="mt-2 border-t pl-2 text-sm"
                        v-show="templateNotes.length > 0"
                    >
                        <li v-for="notes in templateNotes" class="my-1">
                            <div
                                v-if="notes.type == 'html'"
                                v-html="notes.value"
                            ></div>
                            <p v-else>
                                <v-icon
                                    name="bi-chevron-right"
                                    scale="1"
                                ></v-icon>
                                {{ notes.value }}
                            </p>
                        </li>
                    </ul>
                </li>
                <li v-show="templateNotes.length > 0"></li>

                <li>
                    <p v-for="(checkbox, index) in CheckList">
                        <v-checkbox
                            v-model="CheckList[index].isChecked"
                            :label="checkbox.label"
                        ></v-checkbox>
                    </p>
                </li>
                <li class="py-2">
                    <input
                        :disabled="
                            CheckList.filter((el) => el.isChecked == false)
                                .length > 0 
                        "
                        ref="fileUpload"
                        @change="fileSelected"
                        class="block w-full rounded-full border text-sm text-slate-500 file:mr-4 file:rounded-full file:border file:px-4 file:py-2 file:text-sm file:font-semibold file:text-black hover:file:bg-black hover:file:text-white"
                        accept=".xlsx"
                        type="file"
                        :multiple="allowMultiple"
                    />
                    <v-button
                        :disabled="
                            !(list.length > 0) ||
                            !CheckList.filter((el) => el.isChecked == false).length == 0
                        "
                        class="ml-auto mt-6 rounded-full border bg-green-500 text-white disabled:bg-gray-300 disabled:text-black"
                        @click="submit"
                        :loading="isLoading"
                        prepend-inner-icon="fa-cloud-upload-alt"
                        >Submit</v-button
                    >
                    <p class="ml-auto" v-if="isLoading">
                        The data has been received. Updates will reflect soon
                    </p>
                </li>
                <ul class="max-h-[300px] overflow-auto">
                    <li v-for="(file, fileIndex) in list" class="py-2 text-xs">
                        <v-icon
                            class="me-1"
                            color="green"
                            name="bi-check-circle-fill"
                            v-if="file.isDone == true"
                        />
                        <v-icon
                            class="me-1"
                            color="red"
                            name="pr-times-circle"
                            v-if="file.isDone == null"
                        />
                        <v-icon
                            class="me-1"
                            color="warning"
                            name="bi-circle"
                            v-if="file.isDone == false"
                        />
                        {{ file.file_name }}
                    </li>
                </ul>
                <li v-show="pageNotes.length > 0">
                    <ul class="text-sm">
                        <li v-for="notes in pageNotes" class="my-2">
                            <div>
                                <div
                                    class="my-2 rounded-sm"
                                    v-if="notes.type == 'html'"
                                    v-html="notes.value"
                                ></div>
                                <p v-else>
                                    <v-icon
                                        name="bi-chevron-right"
                                        scale="1"
                                    ></v-icon>
                                    {{ notes.value }}
                                </p>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </v-card>
</template>
<script setup>
import { ref } from "vue";
const props = defineProps({
    allowMultiple: {
        type: Boolean,
        default: false,
    },
    pageTitle: {
        type: String,
        default: "No Title",
    },
    actionURL: {
        type: String,
        default: null,
    },
    templateURL: {
        type: String,
        default: null,
    },
    pageNotes: {
        type: Array,
        default: [],
    },
    templateNotes: {
        type: Array,
        default: [],
    },
    isChecked: {
        type: Array,
        default: [],
    },
});
import { useAxios } from "@/composables/useAxios";
const CheckList = ref([]);
CheckList.value = props.isChecked;
CheckList.value = [
    ...CheckList.value,
    {
        isChecked: false,
        label: "By ticking the checkbox, you agree to take responsibility for any incorrect data.",
    },
];

const { exec } = useAxios();

const isLoading = ref(false);

//!SECTION -> File Upload
const list = ref([]);
const selectedFiles = ref([]);
const submit = async () => {
    isLoading.value = true;
    try {
        for (let index = 0; index < selectedFiles.value.length; index++) {
            const file = selectedFiles.value[index];
            const res = await exec(props.actionURL, "post", {
                eFile: file,
            });
            console.log(res)
            if(res.status == 200){
                list.value[index].isDone = true
            }
        }

    } catch (error) {}finally{
        isLoading.value =false;
    }
};

const fileSelected = (e) => {
    list.value = []
    selectedFiles.value = e.target.files;
    for (let index = 0; index < e.target.files.length; index++) {
        const file = e.target.files[index];

        list.value.push({
            file_name: file.name,
            file_size: (file.size / (1024 * 1024)).toFixed(2) + "MB",
            isDone: false,
        });
    }
};
</script>
