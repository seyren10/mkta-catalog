import { computed, reactive, ref } from "vue";
import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";
import { useRouter } from "vue-router";

export const useCompanyStore = defineStore("company", () => {
    const router = useRouter();
    const { loading, errors, exec } = useAxios();

    const company = ref({
        id: 0,
        title: "",
        description: "",
    });
    const companies = ref([]);
    const form = ref({
        title: "",
        description: "",
    });
    const resetForm = ()=>{
            form.value.title = "";
            form.value.description = "";
    }
    const isExist = computed(() => {
        if (
            form.value.title.trim().length == 0 ||
            form.value.description.trim().length == 0
        ) {
            return true;
        }
        return companies.value.some((element) => {
            return (
                element.title.trim().toLowerCase() ==
                    form.value.title.trim().toLowerCase()
            );
        });
    });
    const addCompany = async () => {
        try {
            form.value.title = form.value.title.trim();
            form.value.description = form.value.description.trim();
            const res = await exec("/api/company-code", "post", form.value);
            form.value = {
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
                "put", form.value
            );
            form.value = {
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
