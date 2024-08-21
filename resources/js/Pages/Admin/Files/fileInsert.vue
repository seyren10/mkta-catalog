<template>
    <div>
        <input
            @change="submit"
            :multiple="!false"
            accept=".pdf, .doc, .docx, .jpeg, .jpg, .png, .gif, .webp, .zip, .rar"
            type="file"
        />
        <div class="text-right">
            Files Uploaded {{ list.filter(file => file.isDone == true).length }} / {{ list.length }}
        </div>
        <ul class=" overflow-auto max-h-[300px]">
            <li v-for="(file, fileIndex) in list" class=" py-2 text-lg">
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
        {{ errors }}
        <div class="flex justify-end">
            <v-button
                @click="close()"
                class="my-2 ml-auto border bg-red-500 text-white"
                prepend-inner-icon="la-times-solid"
                >Close</v-button
            >
        </div>
        <ul>
            <li>Note:</li>
            <li>
                Accepts the following file extensions .pdf, .doc, .docx, .jpeg,
                .png, .gif, .webp, .zip, .rar
            </li>
            <li>Maximum File Size: 10MB</li>
        </ul>
    </div>
</template>
<script setup>
//SECTION - required
import { ref, computed } from "vue";
import { storeToRefs } from "pinia";

//SECTION - Store
import { useFileStore } from "@/stores/fileStore";
const fileStore = useFileStore();
const { form, errors } = storeToRefs(fileStore);

//!SECTION - emits
const emit = defineEmits(["close", "submit"]);

const list = ref([]);

const submit = async (e) => {
    const uploadPromises = [];

    for (let index = 0; index < e.target.files.length; index++) {
        const file = e.target.files[index];
        form.value.eFile = file;
        list.value.push({
            file_name: file.name,
            file_size: (file.size / (1024 * 1024)).toFixed(2) + "MB",
            isDone: false,
        });
        fileStore
            .uploadFile()
            .then(() => {
                list.value[index].isDone = true;
            })
            .catch(() => {
                list.value[index].isDone = null;
            });
        // fileStore.uploadFile();
    }
    if (errors) {
    } else {
        emit("close");
    }
};
const close = () => {
    form.value.file = null;
    emit("close");
};
</script>
