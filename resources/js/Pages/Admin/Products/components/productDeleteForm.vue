<template>
    <div class="my-2 grid gap-2p-4">
        <v-button
            @click="isDeleting = true"
            icon="pr-trash"
            class="ml-auto w-full border bg-red-500 text-white p-3"
            />
    </div>
    <v-dialog
        v-model="isDeleting"
        persistent
        title="Product Item Delete"
        @close="()=>{ isDeleting = false }"
    >
        <div class="min-w-[800px] p-5 grid gap-2">
            <v-text-field
                v-model="confirmText"
                :placeholder="'Confirm Delete ' + product_id "
                :label='"Type \"Confirm Delete "+ product_id +"\" to delete"'
            />
            <div class="ml-auto w-fit">
                <v-button
                    @click="submitDelete"
                    :loading="loading"
                    prepend-inner-icon="pr-trash"
                    class="ml-auto w-full border bg-red-500 text-white"
                    >Proceed</v-button
                >
            </div>
        </div>
    </v-dialog>
</template>
<script setup>
import { ref, inject } from "vue";
const props = defineProps({
    product_id: String,
});

const productStore = inject('productStore')
const router = inject('router')


const isDeleting = ref(false);
const loading= ref(false);
const confirmText = ref("");

const submitDelete = async()=>{
    loading.value = true;
    if(!( confirmText.value == ('Confirm Delete ' + props.product_id))){
        loading.value = !true;
        return;
    }
    console.log('C')
    await productStore.deleteProductItem(props.product_id);
    console.log('D')

    loading.value = !true;
    router.push({ name: 'productItemIndex' });
    
}
</script>
