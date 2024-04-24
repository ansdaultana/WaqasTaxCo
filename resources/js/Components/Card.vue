<script setup>
import {gotoCardsRequiredUrl} from '../Navigation.js'
defineProps({
    title: {
        type: String,
        default: null,
    },
    url:{
        type: String,
        default: null,
    }
})
</script>

<template>
    <div
        class="bg-white cursor-pointer shadow-sm  h-52 w-44 p-10 rounded-lg border-gray-100 border-2 transition-transform hover:scale-103 duration-200 ease-out">
        <div class="flex items-center justify-center  text-blue-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-16 h-16">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
            </svg>

        </div>
        <div class="text-xs w-32 py-2" v-text="title">
            
        </div>

        <div 
        @click.prevent="gotoCardsRequiredUrl(url)"
        class="rounded-xl bg-blue-500  p-2  text-white flex items-center justify-center hover:scale-103 transition-transform duration-200 ease-in-out ">
            <span>View</span>
        </div>
    </div>



</template>