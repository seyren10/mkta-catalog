import { computed, ref } from "vue";

export const useToaster = (props) => {
    const toaster = ref({
        children: [],
        timeout: 3000,
        ...props,
    });

    const intervalId = ref(null);

    const lastTime = ref(toaster.value.timeout);

    function addToast(options) {
        options.id = Math.floor(Math.random() * 10_000).toString();

        toaster.value.children.push(options);

        startQueuing();
    }

    function startQueuing() {
        clearInterval(intervalId.value);
        if (!toaster.value.children.length) return;

        intervalId.value = setInterval(() => {
            lastTime.value -= 1000;
            console.log(lastTime.value);
            if (lastTime.value <= 0) {
                toaster.value.children.shift();
                lastTime.value = toaster.value.timeout;
                startQueuing();
            }
        }, 1000);
    }

    return { toaster: toaster.value, addToast };
};
