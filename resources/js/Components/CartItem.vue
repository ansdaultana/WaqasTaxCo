<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    name: String,
    item: Object
})
const emit = defineEmits(['deleteFromCart']);


const RemoveItem = () => {
    emit('deleteFromCart', { item: props.item });
}
</script>

<template>
    <div
        class="bg-white p-5 border-2 border-gray-100 rounded-lg mb-2 mt-2 flex justify-between cursor-pointer transition-transform hover:scale-103  duration-200 ease-in ">
        <div v-text="props.name">

        </div>
        <div class="flex">
            <div class="pr-2">
                Rs:
                <span class="text-blue-500 font-bold" v-text="props.item.price"></span>

            </div>
            <div @click.prevent="RemoveItem" class="bg-white hover:text-red-500 rounded-full hover:bg-red-100">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>
        </div>


    </div>
</template>