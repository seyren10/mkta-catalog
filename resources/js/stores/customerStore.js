import { computed, reactive, ref, shallowRef } from "vue";
import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";

export const useCustomerStore = defineStore("customer", () => {
    const currentCustomer = ref(null);
    const customer = ref([]);

    const customers = ref([]);
    const form = ref({
        name: "",
        email: "",
        password: "",
        company_id: 0,
        is_active: true,
        role_id: 2,
    });

    const { loading, errors, exec } = useAxios();
    //actions
    const isExist = computed(() => {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(form.value.email)) {
            return true;
        }
        if (form.value.email.trim().length == 0) {
            return true;
        }
        return customers.value.some((element) => {
            return (
                element.email.trim().toLowerCase() ==
                form.value.email.trim().toLowerCase()
            );
        });
    });
    const resetForm = () => {
        form.value.name = "";
        form.value.email = "";
        form.value.password = "";
        form.value.is_active = 0;
        form.value.role_id = 2;
    };
    const addCustomer = async () => {
        try {
            const res = await exec("/api/customers", "post", form.value);
        } catch (e) {
            console.log(e);
        }
    };
    const updateCustomer = async (id) => {
        try {
            const res = await exec("/api/customers/" + id, "put", form.value);
        } catch (e) {
            console.log(e);
        }
    };
    const resetPassword = async (id) => {
        try {
            const res = await exec(
                "/api/customers/reset-password/" + id,
                "post",
                form.value,
            );
            form.value.password = res.data.password;
        } catch (e) {
            console.log(e);
        }
    };
    const modifyCustomerPermissions = async (type, permission) => {
        try {
            const res = await exec(
                "/api/customers/" +
                    customer.value.id +
                    "/" +
                    type +
                    "/permissions/" +
                    permission,
                "post",
            );
            getCustomer(customer.value.id);
        } catch (e) {
            console.log(e);
        }
    };
    const modifyCustomerCompanies = async (type, company) => {
        try {
            const res = await exec(
                "/api/customers/" +
                    customer.value.id +
                    "/" +
                    type +
                    "/company-code/" +
                    company,
                "post",
            );
            getCustomer(customer.value.id);
        } catch (e) {
            console.log(e);
        }
    };
    const modifyCustomerAreas = async (type, area) => {
        try {
            const res = await exec(
                "/api/customers/" +
                    customer.value.id +
                    "/" +
                    type +
                    "/area-code/" +
                    area,
                "post",
            );
            getCustomer(customer.value.id);
        } catch (e) {
            console.log(e);
        }
    };
    const getCustomer = async (id, requestData = null) => {
        try {
            let defaultData = {
                includeAreasData: true,
                includeCompaniesData: true,
                includeNonWishlistProducts: true,
                includeNonWishlistProductsKeys: true,
                includeWishListProducts: true,
            };
            const res = await exec("/api/customers/" + id, "get", {
                ...requestData,
                ...defaultData,
            });
            customer.value = res.data.data;
            form.value.name = customer.value.name;
            form.value.email = customer.value.email;
            form.value.is_active = customer.value.is_active;
            form.value.role_id = 2;
        } catch (e) {
            console.log(e);
        }
    };
    const getCustomers = async (requestData = null) => {
        try {
            const res = await exec("/api/customers", "get", requestData);
            customers.value = res.data.data;
        } catch (e) {
            console.log(e);
        }
    };

    const customer_modifyNonWishlistProduct = async (
        action,
        product_id,
        customer_id,
    ) => {
        try {
            const res = await exec(
                ["/api/customer-wishlist"].join("/"),
                "post",
                {
                    action : action,
                    product_id: product_id,
                    user_id: customer_id,
                },
            );
        } catch (e) {
            console.log(e);
        }
    };
    
    return {
        resetForm,
        resetPassword,

        modifyCustomerPermissions,
        modifyCustomerAreas,
        modifyCustomerCompanies,

        addCustomer,
        updateCustomer,
        getCustomer,
        getCustomers,


        customer_modifyNonWishlistProduct,

        isExist,
        currentCustomer,
        form,
        customer,
        customers,
        loading,
        errors,
        exec,
    };
});
