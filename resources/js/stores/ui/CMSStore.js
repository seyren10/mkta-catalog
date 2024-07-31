import { defineStore } from "pinia";
import { markRaw, ref, shallowRef } from "vue";

import Layout from "../../Pages/Admin/CMS/Catalog/CMSLayouts/Layout.vue";
import AutoLayout from "../../Pages/Admin/CMS/Catalog/CMSLayouts/AutoLayout.vue";
import CMSImage from "../../Pages/Admin/CMS/Catalog/CMSImage/CMSImage.vue";

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
            },
        ],
        elements: [
            {
                title: "Image",
                icon: "pr-image",
                component: {
                    type: markRaw(CMSImage),
                    props: {},
                },
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
        console.log(foundNode);
        if (foundNode)
            foundNode.component.props.children = [
                ...foundNode.component.props.children,
                nodeToAdd,
            ];
        else nodes.value.push(nodeToAdd);
    }

    function findNode(nodes, parentId) {
        for (const node of nodes) {
            if (node.component.props.id === parentId) {
                return node;
            }

            if (node.component.props.children) {
                const foundNode = findNode(
                    node.component.props.children,
                    parentId,
                );
                if (foundNode) {
                    return foundNode;
                }
            }
        }

        return null;
    }

    // function findNode(nodes, parentId) {
    //     for (const node of nodes) {
    //         if (node.component.props.id === parentId) {
    //             return node;
    //         } else {
    //             return findNode(node.component.props.children, parentId);
    //         }
    //     }

    //     return null;
    // }
    return {
        addToNodes,
        findNode,
        components,
        nodes,
    };
});
