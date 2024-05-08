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
        parentClass: {
            type: String,
            default:
                "peer order-2 flex min-h-10 items-center gap-1 rounded-md border border-stone-400 bg-white px-2 py-1 duration-300 has-[:disabled]:bg-stone-200 has-[:focus]:ring-2 has-[:focus]:ring-accent has-[:focus]:ring-offset-2",
        },
    };
};
