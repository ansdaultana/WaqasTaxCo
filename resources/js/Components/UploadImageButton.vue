<script setup>
defineProps({
    size: {
        type: String,
        default: 'lg'
    }
})
</script>

<template>
    <div 
        class="cursor-pointer border-gray-200  bg-slate-100 h-10 w-20 md:h-20 md:w-32 border   rounded-lg flex items-center justify-center mt-2">
        <div>
            <div class="flex items-center justify-center">

            <svg class="md:w-10 md:h-10 h-8 w-8  text-gray-600 "
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
            </svg>
        </div>

            <span :class="{ 'h-8 w-8': size === 'md' }" class="text-gray-600 text-xs hidden md:block">Click Here To
                Upload</span>
        </div>

    </div>
</template>