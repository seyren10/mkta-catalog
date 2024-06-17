import {
    ref,
    onMounted,
    computed,
    onBeforeUnmount,
    watch,
    onUpdated,
} from "vue";

export const useHorizontalScroller = (
    autoScroll = false,
    interval = 5000,
    activator,
) => {
    //reactives
    const scroller = ref(null);
    const transitioning = ref(false);
    const currentScroll = ref(0);

    //autoScroll timeout ID
    const id = ref(null);

    const maxScroll = computed(() => {
        return (
            Math.ceil(
                scroller.value?.scrollWidth / scroller.value?.offsetWidth,
            ) - 1
        );
    });

    //methods
    const next = () => {
        if (!transitioning.value) {
            if (currentScroll.value < maxScroll.value) {
                scroller.value.style.left =
                    scroller.value.offsetLeft +
                    -scroller.value.offsetWidth +
                    "px";
                currentScroll.value++;
            } else {
                currentScroll.value = 0;
                scroller.value.style.left = "0px";
            }
        }
    };

    const prev = () => {
        if (!transitioning.value) {
            if (currentScroll.value > 0) {
                scroller.value.style.left =
                    scroller.value.offsetLeft +
                    scroller.value.offsetWidth +
                    "px";
                currentScroll.value--;
            } else {
                currentScroll.value = maxScroll.value;
                scroller.value.style.left =
                    -(scroller.value.offsetWidth * maxScroll.value) + "px";
            }
        }
    };

    const goTo = (page) => {
        //return if page has no value or if its value is within the valid range
        if (!(page >= 0 && page <= maxScroll.value)) return;

        //perform if not transitioning
        if (!transitioning.value) {
            currentScroll.value = page;
            scroller.value.style.left =
                -(scroller.value.offsetWidth * currentScroll.value) + "px";
        }
    };

    const startTransition = (event) => {
        transitioning.value = true;
    };
    const stopTransition = (event) => {
        transitioning.value = false;
    };

    const setAutoScroll = () => {
        if (autoScroll) {
            id.value = setInterval(() => {
                next();
            }, interval);
        }
    };
    const clearAutoScroll = () => {
        if (autoScroll) {
            clearInterval(id.value);
        }
    };

    const addEvents = () => {
        if (!scroller.value) return;
        scroller.value.addEventListener("transitionstart", startTransition);
        scroller.value.addEventListener("transitionend", stopTransition);

        setAutoScroll();
    };

    const removeEvents = () => {
        if (!scroller.value) return;
        scroller.value.removeEventListener("transitionstart", startTransition);
        scroller.value.removeEventListener("transitionend", stopTransition);

        clearAutoScroll();
    };

    //hooks
    onMounted(() => {
        addEvents();
    });

    onBeforeUnmount(() => {
        removeEvents();
    });

    //watchers
    watch(
        activator,
        (newValue) => {
            if (newValue) {
                scroller.value = newValue;
                addEvents();
            } else removeEvents();
        },
        { immediate: true },
    );
    return {
        scroller,
        transitioning,
        currentScroll,
        maxScroll,
        next,
        prev,
        setAutoScroll,
        clearAutoScroll,
        goTo,
    };
};
