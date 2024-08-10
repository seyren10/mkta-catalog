<template>
    <div class="my-2 pl-5 text-2xl">
        <label
            :for="String(keyVal) + '_' + String(parent_Key) + '_' + String(id)"
            class=""
        >
            <input
                type="checkbox"
                :key="
                    String(keyVal) + '_' + String(parent_Key) + '_' + String(id)
                "
                :id="
                    String(keyVal) + '_' + String(parent_Key) + '_' + String(id)
                "
                :checked="model?.includes(id)"
                @click="
                    toogleChecked({
                        sender: id,
                        parent: parent_Key,
                    })
                "
            />
            {{ label }}
        </label>
        <ul v-if="Array.isArray(children)">
            <li v-for="(subCategory, index) in children" :key="index">
                <checkboxDataCategory
                    :keyVal="keyVal"
                    :parent_Key="id"
                    v-model="model"
                    :id="subCategory.id"
                    :label="subCategory.title"
                    :children="subCategory.sub_categories"
                    @change="
                        toogleChecked({
                            sender: subCategory.id,
                            parent: id,
                        })
                    "
                ></checkboxDataCategory>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { ref } from "vue";

const props = defineProps({
    keyVal: "",
    parent_Key: { type: Number, default: 0 },
    id: Number,
    label: String,
    children: Array,
});
const model = defineModel();
const emit = defineEmits(["change", "add_Key", "remove_Key"]);

const toogleChecked = (data) => {
    let index = model.value.indexOf(data.sender);
    if (index == -1) {
        model.value.push(data.sender);
        index = model.value.indexOf(data.parent);
        if (index == -1) {
            model.value.push(data.parent);
        }
    } else {
        model.value.splice(index, 1);
        props.children.forEach((element) => {
            let elementIndex = model.value.indexOf(element.id);
            while (elementIndex > -1) {
                model.value.splice(elementIndex, 1);
                elementIndex = model.value.indexOf(element.id);
            }
        });
    }
    emit('change')
};
</script>
