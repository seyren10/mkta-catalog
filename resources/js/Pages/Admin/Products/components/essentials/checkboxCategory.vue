<template>
    <div class="my-2 pl-5 text-xl">
        <label :for="id" class="">
            <input
                type="checkbox"
                :id="id"
                :checked="model?.includes(id)"
                @click="
                    (data) => {
                        
                        let method = 'add';
                        if (!model?.includes(id)) {
                            model.push(id);
                            method = 'add';
                        } else {
                            model.splice(model.indexOf(id), 1);
                            let fuck = [];
                            children.forEach((element) => {
                                fuck.push(element.id)
                                model.splice(model.indexOf(element.id), 1);
                                if (!element.sub_categories) {
                                    element.forEach((child) => {
                                        fuck.push(child.id)
                                        model.splice(
                                            model.indexOf(child.id),
                                            1,
                                        );
                                    });
                                }
                            });
                            method = 'remove';
                        }
                        emit('change', {
                            parentKey: parent_Key,
                            senderKey: id,
                            method: method,
                        });
                    }
                "
            />
            {{ label }}
        </label>
        <ul v-if="Array.isArray(children)">
            <li v-for="(subCategory, index) in children" :key="index">
                <checkboxCategory
                    :parent_Key="id"
                    v-model="model"
                    :id="subCategory.id"
                    :label="subCategory.title"
                    :children="subCategory.sub_categories"
                    @change="
                        (data) => {
                            if (data.method == 'remove') {
                                model.splice(model.indexOf(id), 1);
                            } else {
                                model.push(id);
                            }
                            emit('change', {
                                parentKey: data.senderKey,
                                senderKey: data.parentKey,
                                method: data.method,
                            });
                        }
                    "
                ></checkboxCategory>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { ref } from "vue";

const props = defineProps({
    parent_Key: { type: Number, default: 0 },
    id: Number,
    label: String,
    children: Array,
});
const model = defineModel();

const emit = defineEmits(["change", "add_Key", "remove_Key"]);

const handle_AppendKey = (key) => {
    if (key.id === props.id) {
        model.value.push(key.id);
    }
};
const handle_RemoveKey = (key) => {
    if (key.id === props.id) {
        model.value.splice(model.value.indexOf(key.id), 1);
    }
};
</script>
