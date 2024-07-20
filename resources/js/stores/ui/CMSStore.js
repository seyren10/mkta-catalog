import { defineStore } from "pinia";
import { ref } from "vue";
import CMSGrid from "../../Pages/Admin/CMS/Catalog/CMSGrid/CMSGrid.vue";
import CMSImage from "../../Pages/Admin/CMS/Catalog/CMSImage/CMSImage.vue";

export const useCMSStore = defineStore("CMSStore", () => {
    const parentNode = ref({
        component: CMSGrid,
        props: {
            notClosable: true,
            parentId: "root",
            id: "root",
            children: [],
            type: "root",
        },
    });

    const components = {
        layouts: [
            {
                title: "grid",
                icon: "ri-checkbox-blank-line",
                component: CMSGrid,
                props: {
                    type: "grid",
                    children: [],
                },
            },
            {
                title: "auto-fit grid",
                icon: "bi-grid",
                component: CMSGrid,
                props: {
                    type: "grid-auto-fit",
                    children: [],
                },
            },
        ],
        elements: [
            {
                title: "image",
                icon: "pr-image",
                component: CMSImage,
                props: {
                    type: "image",
                },
            },
            { title: "image carousel", icon: "pr-images", type: "carousel" },
        ],
    };

    function addNode(node) {
        console.log(node);
        const parentOfRootNode =
            parentNode.value.props.id === node.props.parentId;

        if (parentOfRootNode) {
            parentNode.value.props.children.push(node);
        } else {
            const childNode = findChild(node, parentNode.value);

            if (childNode) {
                childNode.props.children.push(node);
            }
        }
    }

    function removeNode(node) {
        const parentOfRootNode =
            parentNode.value.props.id === node.props.parentId;

        if (parentOfRootNode) {
            parentNode.value.props.children =
                parentNode.value.props.children.filter(
                    (n) => n.props.id !== node.props.id,
                );
        } else {
            const childNode = findChild(node, parentNode.value);

            if (childNode) {
                childNode.props.children = childNode.props.children.filter(
                    (n) => n.props.id !== node.props.id,
                );
            }
        }
    }

    function findChild(node, parent) {
        for (const child of parent.props.children) {
            if (child.props.id === node.props.parentId) {
                return child;
            } else {
                const found = findChild(node, child);
                if (found) return found;
            }
        }

        return null;
    }

    return {
        addNode,
        parentNode,
        removeNode,
        components,
    };
});
