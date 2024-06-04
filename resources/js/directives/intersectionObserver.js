export default {
    created(el, binding) {
        const { callback, options } = binding.value;

        // Initializing observer in the created hook to ensure it's ready before mounting
        const observerOptions = {
            root: options?.root || null,
            rootMargin: options?.rootMargin || "200px",
            threshold: options?.threshold || 0, // Adjust as needed
        };

        const observerCallback = (entries, observer) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    callback ? callback(entry) : binding.value(entry); // Call the bound method
                    el._observer.unobserve(el);
                }
            });
        };

        el._observer = new IntersectionObserver(
            observerCallback,
            observerOptions,
        );
    },
    mounted(el) {
        // Observe the element when it is mounted
        el._observer.observe(el);
    },
    beforeUnmount(el) {
        // Disconnect the observer when the element is about to be unmounted
        if (el._observer) {
            el._observer.disconnect();
        }
    },
};
