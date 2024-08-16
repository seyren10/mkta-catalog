import { computed, reactive, ref } from "vue";
import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";
import { useRouter } from "vue-router";

export const useFileStore = defineStore("portalFiles", () => {
    const router = useRouter();
    const { loading, errors, exec } = useAxios();

    const files = ref([]);
    const file = ref([]);
    const form = ref({
        title: "",
        eFile: null,
    });
    const resetform = () => {
        form.value.eFile = null;
        form.value.title = "";
    };
    const uploadFile = async () => {
        try {
            const res = await exec("/api/portal-files", "post", form.value);
        } catch (e) {
            form.value.eFile = null
        }
    };
    const renameFile = async (id, FileName) => {
        try {
            const res = await exec("/api/portal-files/" + id, "put", {
                title: FileName,
            });
            resetform();
        } catch (e) {
            console.log(e);
        }
    };
    const deleteFile = async (id) => {
        try {
            const res = await exec("/api/portal-files/" + id, "delete");
            resetform();
        } catch (e) {
            console.log(e);
        }
    };
    const getFiles = async () => {
        try {
            const res = await exec("/api/portal-files");
            files.value = res.data.data;
        } catch (e) {
            console.log(e);
        }
    };
    
    return {
        resetform,
        uploadFile,
        renameFile,
        deleteFile,
        getFiles,

        loading,
        errors,
        form,
        exec,

        files,
        file,
    };
});
