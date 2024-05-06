<script setup>
const props = defineProps({
    url: {
        type: String,
    },
    size: {
        type: String,
        default: 'lg'
    },
    index: {
        type: Number
    },

    id: {
        type: Number
    }

});
const emit = defineEmits(['deleteImage']);
const RemoveThisImage = () => {
   
    if (props.id) {
        emit('deleteImageInBackend', { url: props.url, index: props.index, id: props.id });
    }
    else {
        emit('deleteImage', { url: props.url, index: props.index });
    }
}

</script>

<template>

    <div :class="{ 'h-8 w-8 md:h-16 md:w-16': size === 'md' }, { 'h-10 w-10 md:h-20 md:w-20': size === 'lg' }"
        class="relative cursor-pointer border-gray-100 bg-slate-100 rounded-lg mt-2">


        <div class="right-0 absolute rounded-full  -mt-2">
            <div @click.prevent="RemoveThisImage" class="bg-white hover:text-red-500 rounded-full hover:bg-red-100">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>

        </div>
        <div class=" rounded-lg flex items-center  justify-center " >
            <img class="rounded-lg  " :src="props.url" alt=""  :class="{ 'h-8 w-8 md:h-16 md:w-16': size === 'md' }, { 'h-10 w-10 md:h-20 md:w-20': size === 'lg' }" >

        </div>

    </div>
</template>