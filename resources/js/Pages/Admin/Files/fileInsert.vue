<template>
    <div>
        <input
            @change="submit"
            :multiple="!false"
            accept=".pdf, .doc, .docx, .jpeg, .jpg, .png, .gif, .webp, .zip, .rar"
            type="file"
        />

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

const submit = async (e) => {
    for (let index = 0; index < e.target.files.length; index++) {
        const file = e.target.files[index];
        form.value.eFile = file;
        await fileStore.uploadFile();
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
