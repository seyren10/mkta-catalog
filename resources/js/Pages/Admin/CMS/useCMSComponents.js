import CMSGrid from "./Catalog/CMSGrid/CMSGrid.vue";

export const useCMSComponents = () => {
    function getComponentByType(type) {
        switch (type) {
            case "grid": {
                return CMSGrid;
            }
        }
    }

    return { getComponentByType };
};
