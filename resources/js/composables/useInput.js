import { computed, defineProps } from "vue";
export const useInput = () => {
    return {
        prependIcon: {
            type: String,
        },
        prependInnerIcon: {
            type: String,
        },
        appendIcon: {
            type: String,
        },
        appendInnerIcon: {
            type: String,
        },
        label: {
            type: String,
        },
        loading: {
            type: Boolean,
        },
        wrapperClass: {
            type: String,
        },
    };
};

export const useDensity = () => {
    return {
        density: {
            type: String,
            default: "default",
        },
    };
};

export const useDensityValues = (prop) => {
    switch (prop) {
        case "default":
            return "p-2 px-3";
        case "compact": {
            return "p-0.5 px-2";
        }
        case "comfortable": {
            return "p-4 px-5";
        }
        default:
            break;
    }
};
