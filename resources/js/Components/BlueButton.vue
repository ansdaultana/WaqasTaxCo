<script setup>
const props=defineProps({
    text: {
        type: String,
        default: null,
    },
   
})
</script>
<template>
    <button v-text="props.text" class="items-center p-2 bg-blue-500 text-white transition-transform hover:scale-103 duration-300 cursor-pointer rounded-lg hover:bg-blue-600"></button>
</template>
