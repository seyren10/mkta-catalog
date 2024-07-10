import { computed, reactive, ref, shallowRef } from "vue";
import { defineStore } from "pinia";
import { useAxios } from "@/composables/useAxios";

export const useCategoryStore = defineStore("categories", () => {
    const { loading, errors, exec } = useAxios();
    /*
    const categories = reactive([
        {
            id: 1,
            name: "Christmas",
            img: "/mk-images/categories/christmas.jpg",
            subCategories: [
                "Christmas Balls",
                "Christmas Characters",
                "Elves",
                "Reindeers",
                "Snowmen",
                "Gingerbreads",
                "Nutcrackers",
                "Sleighs",
                "Archways",
                "Trees",
                "Candies",
                "Photo Ops",
                "Chairs & Tables",
                "Toys",
                "Props",
                "Winter",
            ],
        },
        {
            id: 2,
            name: "Halloween",
            img: "/mk-images/categories/halloween.jpg",
            subCategories: [
                "Halloween Characters",
                "Pumpkins",
                "Skeletons",
                "Mice",
                "Scarecrows",
                "Chairs & Tables",
                "Trees",
                "Coffins",
                "Archways",
                "Photo Ops",
                "Gravestones",
                "Props",
            ],
        },
        {
            id: 3,
            name: "Easter",
            img: "/mk-images/categories/easter.jpg",
            subCategories: [
                "Easter Eggs",
                "Easter Characters",
                "Bunnies",
                "Lambs",
                "Chairs & Tables",
                "Photo Ops",
                "Archways",
                "Props",
                "Candies",
            ],
        },
        {
            id: 4,
            name: "Summer and Spring",
            img: "/mk-images/categories/summer.jpg",
            subCategories: ["Flowers", "Animals", "Food & Beverages"],
        },
        {
            id: 5,
            name: "Animals",
            img: "/mk-images/categories/animals.jpg",
            subCategories: [
                "Safari",
                "Forest",
                "Reptiles",
                "Insects",
                "Marine",
                "Farm",
                "Domestic",
                "Birds",
                "Arctic",
            ],
        },
        {
            id: 6,
            name: "Dinosaurs",
            img: "/mk-images/categories/dinosaurs.jpg",
            subCategories: ["Coming soon..."],
        },
        {
            id: 7,
            name: "Pirates",
            img: "/mk-images/categories/pirates.jpg",
            subCategories: [
                "Pirate Characters",
                "Chairs & Tables",
                "Crates",
                "Barrels",
                "Props",
            ],
        },
        {
            id: 8,
            name: "Wild West",
            img: "/mk-images/categories/wild_west.jfif",
            subCategories: [
                "Wild West Characters",
                "Chairs & Tables",
                "Crates",
                "Barrels",
                "Hays",
                "Photo Ops",
                "Props",
            ],
        },
        {
            id: 9,
            name: "Food and Beverage",
            img: "/mk-images/categories/food_and_beverages.jpg",
            subCategories: [
                "Christmas",
                "Halloween",
                "Easter",
                "Gingerbreads",
                "Food & Beverages",
                "Animals",
                "Cars",
                "Farm",
                "Pirates",
                "Wild West",
            ],
        },
        {
            id: 10,
            name: "Wall Decor",
            img: "/mk-images/categories/wall_decor.jpg",
            subCategories: [
                "Animals",
                "Pre-Historic",
                "Food & Beverages",
                "Halloween",
                "Cars",
                "Medieval",
            ],
        },
        {
            id: 11,
            name: "Archways",
            img: "/mk-images/categories/archways.jpg",
            subCategories: ["Christmas", "Halloween", "Easter"],
        },
        {
            id: 12,
            name: "Photo ops",
            img: "/mk-images/categories/photo_ops.jpg",
            subCategories: [
                "Christmas",
                "Halloween",
                "Easter",
                "Food & Beverages",
                "All-Year",
            ],
        },
        {
            id: 13,
            name: "Comics",
            img: "/mk-images/categories/comics.jpg",
            subCategories: [
                "Panda",
                "Penguins",
                "Farm Animals",
                "Photo Ops",
                "Props",
                "Play Equipments",
            ],
        },
        {
            id: 14,
            name: "Space",
            img: "/mk-images/categories/space.jfif",
            subCategories: ["Aliens", "UFO", "Astronaut"],
        },
        {
            id: 15,
            name: "Statues",
            img: "/mk-images/categories/statues.jpg",
            subCategories: [
                "Stones",
                "Christmas Characters",
                "Mermaids",
                "Comic Sports",
                "Celebrities",
            ],
        },
        {
            id: 16,
            name: "Inlitefi",
            img: "/mk-images/inlitefi.jpg",
            subCategories: [
                "Christmas",
                "Halloween",
                "Easter",
                "Summer",
                "Animals",
                "All-Year",
            ],
        },
    ]);
     */
    const categories = ref([]);
    const category = ref([]);
    const form = reactive({
        img: "",
        title: "",
        description: "",
        parent_id: 0,
        file_id: 0,
    });
    const resetForm = () => {
        form.title = "";
        form.description = "";
        form.parent_id = 0;
        form.file_id = 0;
    };
    const addCategory = async () => {
        try {
            const res = await exec("/api/categories", "post", form);
            if (form.parent_id != 0) {
                getCategory(form.parent_id);
            } else {
                getCategories();
            }
        } catch (e) {
            console.log(e);
        }
    };
    const updateCategory = async (id) => {
        try {
            const res = await exec("/api/categories/" + id, "put", form);
            getCategory(id);
        } catch (e) {
            console.log(e);
        }
    };
    const updateCategoryImage = async (id, file_id) => {
        try {
            const res = await exec("/api/categories/image/" + id, "put", {
                file_id: file_id,
            });
            getCategory(id);
        } catch (e) {
            console.log(e);
        }
    };

    const deleteCategory = async (id) => {
        try {
            const res = await exec("/api/categories/" + id, "delete");
            await getCategories();
        } catch (e) {
            console.log(e);
        }
    };
    const getCategory = async (id, requestData = null) => {
        try {
            let defaultData = {
                includeSubCategories: true,
                includeFile: true,
                includeParentCategory: true,
            };
            const res = await exec("/api/categories/" + id, "get", {
                ...requestData,
                ...defaultData,
            });
            category.value = res.data.data;
            form.title = category.value.title;
            form.description = category.value.description;
            form.parent_id = category.value.parent_id;
            form.file_id = category.value.file_id ?? category.img;
        } catch (e) {
            console.log(e);
        }
    };
    const getCategories = async (requestData = null) => {
        try {
            const res = await exec("/api/categories", "get", requestData);
            categories.value = res.data.data;
        } catch (e) {
            console.log(e);
        }
    };

    const getCategoryWithId = (categoryId) => {
        if (categories.value.length)
            return categories.value.find((e) => e.id === categoryId);
    };

    return {
        form,
        category,
        categories,
        loading,
        errors,
        exec,

        resetForm,
        addCategory,
        updateCategory,
        deleteCategory,
        getCategory,
        getCategories,
        getCategoryWithId,
        updateCategoryImage
    };
});
