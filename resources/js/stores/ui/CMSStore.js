import { defineStore } from "pinia";
import { markRaw, ref, unref } from "vue";

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
            {
                title: "Image Carousel",
                icon: "pr-images",
                component: {
                    type: markRaw(CMSCarousel),
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
                    ? { ...n, cmsData: { ...node.cmsData } }
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

    return {
        addToNodes,
        deleteNode,
        findNode,
        updateNode,
        components,
        nodes,
    };
});
