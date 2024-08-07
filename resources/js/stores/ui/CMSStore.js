import { defineStore } from "pinia";
import { markRaw, ref } from "vue";

import Layout from "../../Pages/Admin/CMS/Catalog/CMSLayouts/Layout.vue";
import AutoLayout from "../../Pages/Admin/CMS/Catalog/CMSLayouts/AutoLayout.vue";
import CMSImage from "../../Pages/Admin/CMS/Catalog/CMSImage/CMSImage.vue";
import CMSCarousel from "../../Pages/Admin/CMS/Catalog/CMSCarousel/CMSCarousel.vue";

export const useCMSStore = defineStore("CMSStore", () => {
    const nodes = ref([]);

    const components = ref({
        layouts: [
            {
                title: "1:1 Layout",
                icon: "ri-checkbox-blank-line",
                component: {
                    type: markRaw(Layout),
                    props: {
                        children: [],
                    },
                },
                type: "layout",
            },
            {
                title: "auto-fit layout",
                icon: "bi-grid",
                component: {
                    type: markRaw(AutoLayout),
                    props: {
                        children: [],
                    },
                },
                type: "layout-auto",
            },
        ],
        elements: [
            {
                title: "Image",
                icon: "pr-image",
                component: {
                    type: markRaw(CMSImage),
                    props: {
                        link: false,
                        path: "/",
                        image: null,
                    },
                },
                type: "image",
            },
            {
                title: "Image Carousel",
                icon: "pr-images",
                component: {
                    type: markRaw(CMSCarousel),
                    props: {},
                },
                type: "carousel",
            },
        ],
    });

    function addToNodes(node, parentId) {
        const nodeToAdd = {
            ...node,
            component: {
                ...node.component,
                props: {
                    ...node.component.props,
                    id: Math.floor(Math.random() * 10_000_000).toString(),
                    parentId: parentId
                        ? parentId
                        : Math.floor(Math.random() * 10_000_000).toString(),
                },
            },
        };

        const foundNode = findNode(
            nodes.value,
            nodeToAdd.component.props.parentId,
        );

        if (foundNode)
            foundNode.component.props.children = [
                ...foundNode.component.props.children,
                nodeToAdd,
            ];
        else nodes.value.push(nodeToAdd);
    }

    function deleteNode(node) {
        const foundNode = findNode(nodes.value, node.parentId);

        if (foundNode) {
            //node is a sub-node (child of existing parent node)
            foundNode.component.props.children =
                foundNode.component.props.children.filter(
                    (n) => n.component.props.id !== node.id,
                );
        } else {
            //node is part of root nodes (top level node)
            nodes.value = nodes.value.filter(
                (n) => n.component.props.id !== node.id,
            );
        }
    }

    function updateNode(node) {
        const foundNode = findNode(nodes.value, node.parentId);

        if (foundNode) {
            //node is a sub-node (child of existing parent node)
            foundNode.props.children = foundNode.props.children.map((child) => {
                return node.id === child.id ? node : child;
            });
        } else {
            console.log(node);
            //node is part of root nodes (top level node)
            nodes.value = nodes.value.map((n) => {
                return n.component.props.id === node.id
                    ? {
                          ...n,
                          data: JSON.parse(JSON.stringify(node.data)),
                      }
                    : n;
            });
        }
    }

    function findNode(nodes, id) {
        for (const node of nodes) {
            if (node.component.props.id === id) {
                return node;
            }

            if (node.component.props.children) {
                const foundNode = findNode(node.component.props.children, id);
                if (foundNode) {
                    return foundNode;
                }
            }
        }

        return null;
    }

    function saveNodes() {
        localStorage.setItem("nodes", JSON.stringify(nodes.value));
    }

    function getNodes() {
        const val = JSON.parse(localStorage.getItem("nodes"));

        if (!val) return;
        val.forEach((node) => {
            node.component.type = getComponentType(node.type);
        });

        console.log(val);

        nodes.value = val;
    }

    function getComponentType(type) {
        switch (type) {
            case "image":
                return markRaw(CMSImage);
            case "carousel":
                return markRaw(CMSCarousel);
            case "layout":
                return markRaw(Layout);
            case "layout-auto":
                return markRaw(AutoLayout);
            case "image":
                return markRaw(CMSImage);

            default:
                break;
        }
    }

    return {
        addToNodes,
        deleteNode,
        findNode,
        updateNode,
        saveNodes,
        getNodes,
        components,
        nodes,
    };
});
