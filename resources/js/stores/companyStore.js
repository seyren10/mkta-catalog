import { computed, reactive, ref } from "vue";
import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";
import { useRouter } from "vue-router";

export const useCompanyStore = defineStore("company", () => {
    const router = useRouter();
    const { loading, errors, exec } = useAxios();

    const company = reactive({
        id: 0,
        title: "",
        description: "",
    });
    const companies = ref([]);
    const form = reactive({
        title: "",
        description: "",
    });
    const resetForm = ()=>{
            form.title = "";
            form.description = "";
    }
    const isExist = computed(() => {
        if (
            form.title.trim().length == 0 ||
            form.description.trim().length == 0
        ) {
            return true;
        }
        return companies.value.some((element) => {
            return (
                element.title.trim().toLowerCase() ==
                    form.title.trim().toLowerCase()
            );
        });
    });
    const addCompany = async () => {
        try {
            form.title = form.title.trim();
            form.description = form.description.trim();
            const res = await exec("/api/company-code", "post", form);
            form = {
                title: "",
                description: "",
            };
        } catch (e) {
            console.log(e);
        }
    };
    const updateCompany = async (id) => {
        try {
            const res = await exec(
                "/api/company-code/" + id,
                "put", form
            );
            form = {
                title: "",
                description: "",
            };
        } catch (e) {
            console.log(e);
        }
    };
    const deleteCompany = async (id) => {
        try {
            const res = await exec(
                "/api/company-code/" + id,
                "delete",
            );
        } catch (e) {
            console.log(e);
        }
    };
    const getCompany = async () => {
        try {
            const res = await exec("/api/company-code/" + company.id);
            companies.value = res.data.data;
        } catch (e) {
            console.log(e);
        }
    };
    const getCompanies = async () => {
        try {
            const res = await exec("/api/company-code");
            companies.value = res.data.data;
        } catch (e) {
            console.log(e);
        }
    };

    return {
        resetForm,
        addCompany,
        updateCompany,
        deleteCompany,
        getCompany,
        getCompanies,

        isExist,
        company,
        companies,
        loading,
        errors,
        form,
        exec,
    };
});
