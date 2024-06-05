export default {
    mounted(el, binding) {
        const { parent, child } = binding.value;

        el.handleShowMenu = () => {
            const parentBound = parent.getBoundingClientRect();
            const parentTop = parentBound.top;
            const parentHeight = parentBound.height;
            const childBound = child.getBoundingClientRect();
            const windowWidth = window.innerWidth;

            child.style.top = parentTop + parentHeight + 8 + "px";

            if (parentBound.left > windowWidth / 2) {
                if (childBound.width < windowWidth - (windowWidth - parentBound.right)) {
                    child.style.left = `${parentBound.right - childBound.width}px`;
                }
            } else {
                child.style.left = parentBound.left + "px";
            }

            if (childBound.width < windowWidth - (windowWidth - parentBound.right)) {
                child.style.marginInline = "0";
            } else {
                child.style.marginInline = ".5rem";
            }
        };

        el.handleShowMenu();
    },
    unmounted(el) {
        delete el.handleShowMenu;
    },
};