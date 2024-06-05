export default {
    created: (el, binding) => {
        const offset = +binding.arg;

        el.handleScroll = () => {
            if (window.scrollY > offset) {
                binding.value(el, false);
            } else binding.value(el, true);
        };
    },
    mounted: (el, binding) => {
        window.addEventListener("scroll", el.handleScroll);
        el.handleScroll();
    },
    unmounted: (el) => {
        window.removeEventListener("scroll", el.handleScroll);
    },
};
