import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";
import { ref } from "vue";
export const useCMSStore = defineStore("CMSStore", () => {
    const { loading, errors, exec } = useAxios();

    const templates = ref([]);
    const editingTemplate = ref({});
    const activeTemplate = ref({});

    async function getContents() {
        const res = await exec("/api/content-management");

        templates.value = res.data.data;

        activeTemplate.value = editingTemplate.value = templates.value.find(
            (t) => t.active,
        );
        return res.data.data;
    }

    async function getContent(id) {
        const res = await exec(`/api/content-management/${id}`);
        res.data = JSON.parse(res.data.data);
        return res.data;
    }

    async function updateContent(id, form) {
        await exec(`/api/content-management/${id}`, "put", form);
    }

    async function addContent(form) {
        await exec("/api/content-management", "post", form);
    }

    async function setActiveContent(id) {
        await exec(`/api/content-management/set-active-content/${id}`, "put");
        await getContents();
    }

    return {
        loading,
        errors,
        exec,
        getContents,
        addContent,
        updateContent,
        getContent,
        templates,
        editingTemplate,
        setActiveContent,
        activeTemplate,
    };
});
