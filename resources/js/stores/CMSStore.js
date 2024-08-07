import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";
export const useCMSStore = defineStore("CMSStore", () => {
    const { loading, errors, exec } = useAxios();

    async function getContents() {
        const res = await exec("/api/content-management");

        return res.data.data;
    }

    async function getContent(id) {
        const res = await exec(`/api/content-management/${id}`);
        res.data = JSON.parse(res.data.data);
        return res.data;
    }

    async function addContent(form) {
        await exec("/api/content-management", "post", form);
    }

    return { loading, errors, exec, getContents, addContent, getContent };
});
