import { defineStore } from "pinia";
import { markRaw, ref } from "vue";

import Layout from "../../Pages/Admin/CMS/Catalog/CMSLayouts/Layout.vue";
import AutoLayout from "../../Pages/Admin/CMS/Catalog/CMSLayouts/AutoLayout.vue";
import CMSImage from "../../Pages/Admin/CMS/Catalog/CMSImage/CMSImage.vue";
import CMSCarousel from "../../Pages/Admin/CMS/Catalog/CMSCarousel/CMSCarousel.vue";
import CMSTextOnImage from "../../Pages/Catalog/CMS/CMSTextOnImage.vue";
import CMSLayout from "../../Pages/Catalog/CMS/CMSLayout.vue";
import CMSAutoLayout from "../../Pages/Catalog/CMS/CMSAutoLayout.vue";
import CMSCatalogCarousel from "../../Pages/Catalog/CMS/CMSCatalogCarousel.vue";
import CMSFeaturedProducts from "../../Pages/Admin/CMS/Catalog/CMSFeaturedProducts/CMSFeaturedProducts.vue";
import CMSCatalogFeaturedProducts from "../../Pages/Catalog/CMS/CMSCatalogFeaturedProducts.vue";
import CMSH from "../../Pages/Admin/CMS/Catalog/CMSTypography/CMSH.vue";
import CMSParagraph from "../../Pages/Admin/CMS/Catalog/CMSTypography/CMSParagraph.vue";
import CMSCatalogHeading from "../../Pages/Catalog/CMS/CMSCatalogHeading.vue";
import CMSCatalogParagraph from "../../Pages/Catalog/CMS/CMSCatalogParagraph.vue";
import CMSSeasonalProducts from "../../Pages/Admin/CMS/Catalog/CMSSeasonalProducts/CMSSeasonalProducts.vue";

export const useCMSUIStore = defineStore("CMSUIStore", () => {
    const nodes = ref([]);
    const environment = ref("admin");

    const components = ref({
        layouts: [
            {
                title: "Grid",
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
                title: "Grid Item",
                icon: "bi-grid",
                component: {
                    type: markRaw(AutoLayout),
                    props: {
                        children: [],
                        size: 12,
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
            {
                title: "Featured Products",
                icon: "co-star",
                component: {
                    type: markRaw(CMSFeaturedProducts),
                    props: {},
                },
                type: "products",
            },
            {
                title: "Seasonal Products",
                icon: "ri-leaf-line",
                component: {
                    type: markRaw(CMSSeasonalProducts),
                },
                type: "seasonal",
            },
        ],
        typography: [
            {
                title: "Heading",
                icon: "ri-heading",
                component: {
                    type: markRaw(CMSH),
                    props: {},
                },
                type: "heading",
            },
            {
                title: "Paragraph",
                icon: "ri-paragraph",
                component: {
                    type: markRaw(CMSParagraph),
                    props: {},
                },
                type: "paragraph",
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
            console.log(foundNode);
            //node is a sub-node (child of existing parent node)
            foundNode.component.props.children =
                foundNode.component.props.children.map((child) => {
                    return node.id === child.component.props.id
                        ? {
                              ...child,
                              data: JSON.parse(JSON.stringify(node.data)),
                          }
                        : child;
                });
        } else {
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

    function getNodes(data, env = "admin") {
        environment.value = env;
        if (!data) return;

        setComponentType(data);

        nodes.value = data;
    }

    function setComponentProps(props) {
        const foundNode = findNode(nodes.value, props.parentId);

        if (foundNode) {
            console.log(foundNode);
            //node is a sub-node (child of existing parent node)
            foundNode.component.props.children =
                foundNode.component.props.children.map((child) => {
                    return child.component.props.id === props.id
                        ? {
                              ...child,
                              component: {
                                  ...child.component,
                                  props: {
                                      ...props,
                                  },
                              },
                          }
                        : child;
                });
        } else {
            //node is part of root nodes (top level node)
            nodes.value = nodes.value.map((n) => {
                return n.component.props.id === props.id
                    ? {
                          ...n,
                          component: {
                              ...n.component,
                              props: {
                                  ...props,
                              },
                          },
                      }
                    : n;
            });
        }
    }

    function setComponentType(nodes) {
        nodes.forEach((node) => {
            node.component.type = getComponentType(node.type);

            const subNodes = node.component.props.children;

            if (subNodes) {
                setComponentType(subNodes);
            }
        });
    }

    function getComponentType(type) {
        switch (type) {
            case "image":
                return markRaw(
                    environment.value === "admin" ? CMSImage : CMSTextOnImage,
                );
            case "carousel":
                return markRaw(
                    environment.value === "admin"
                        ? CMSCarousel
                        : CMSCatalogCarousel,
                );
            case "layout":
                return markRaw(
                    environment.value === "admin" ? Layout : CMSLayout,
                );
            case "layout-auto":
                return markRaw(
                    environment.value === "admin" ? AutoLayout : CMSAutoLayout,
                );
            case "products":
                return markRaw(
                    environment.value === "admin"
                        ? CMSFeaturedProducts
                        : CMSCatalogFeaturedProducts,
                );
            case "heading":
                return markRaw(
                    environment.value === "admin" ? CMSH : CMSCatalogHeading,
                );
            case "paragraph":
                return markRaw(
                    environment.value === "admin"
                        ? CMSParagraph
                        : CMSCatalogParagraph,
                );

            default:
                break;
        }
    }

    function moveNode(node, direction = "up") {
        const parentNode = findNode(nodes.value, node.parentId);

        if (parentNode) {
            console.log("a sub node");
            //node is a sub-node (child of existing parent node)
            // parentNode.component.props.children =
            //     parentNode.component.props.children.filter(
            //         (n) => n.component.props.id !== node.id,
            //     );
        } else {
            //node is part of root nodes (top level node)
            const nodeIndex = nodes.value.findIndex((n) => {
                return n.component.props.id === node.id;
            });

            if (nodeIndex > 0 && direction === "up") {
                [nodes.value[nodeIndex], nodes.value[nodeIndex - 1]] = [
                    nodes.value[nodeIndex - 1],
                    nodes.value[nodeIndex],
                ];
            } else if (
                nodeIndex < nodes.value.length - 1 &&
                direction === "down"
            ) {
                [nodes.value[nodeIndex], nodes.value[nodeIndex + 1]] = [
                    nodes.value[nodeIndex + 1],
                    nodes.value[nodeIndex],
                ];
            }
        }
    }

    return {
        addToNodes,
        deleteNode,
        findNode,
        updateNode,
        setComponentProps,
        getNodes,
        components,
        nodes,
        environment,
        moveNode,
    };
});
