import { computed, ref } from "vue";

export const useToaster = (props) => {
    const toaster = ref({
        children: [],
        timeout: 3000,
        ...props,
    });

    const intervalId = ref(null);

    function addToast(options) {
        options.id = Math.floor(Math.random() * 10_000).toString();

        toaster.value.children.push(options);

        if (!intervalId.value) startQueuing();
    }

    function startQueuing() {
        if (!toaster.value.children.length) {
            intervalId.value = null;
            return;
        }

        intervalId.value = setTimeout(() => {
            toaster.value.children.shift();
            startQueuing();
        }, toaster.value.children[0].timeout || toaster.value.timeout);
    }

    return { toaster: toaster.value, addToast };
};
