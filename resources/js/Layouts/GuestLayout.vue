<script setup>
import { defineProps } from 'vue';
 import {gotoHome} from '../Navigation.js'

const props = defineProps({
  mode: String,
})

</script>

<template>


  <div class="flex min-h-screen justify-between ">
    <div v-if="mode != 'vendor'" class="hidden lg:block w-2/3 ">
      <img src="/Images/GuestImg.jpg" class=" rounded-r-3xl shadow-2xl h-screen  " alt="">

    </div>
    <div :class="{ 'w-full': mode === 'vendor', 'lg:w-1/2': mode !== 'vendor' }"
      class="flex items-center justify-center w-full  m-2 border-gray-500  ">
      <div :class="{ 'md:p-10': mode === 'vendor', 'md:p-16': mode !== 'vendor' }" class="shadow-2xl shadow-blue-400 border-gray-300 border-2 p-4  rounded-xl">
        <div class="flex-col items-center justify-center ">
          <div class="flex items-center justify-center cursor-pointer " @click.prevent="gotoHome">
            <span class="font-extrabold text-3xl text-blue-500">Waqas</span>
            <span class="text-3xl ml-1"> Tax</span>
        
            <span class="text-3xl text-blue-500 ml-1">&</span>
            <span class="text-3xl ml-1"> Co</span>

          </div>
          <div class="mt-3 justify-center flex">
            Everything you want is here!
          </div>

        </div>
        <div class="mt-5 sm:mx-auto sm:w-full sm:max-w-sm">
          <slot />
        </div>
      </div>
    </div>
  </div>

</template>

<style>
@keyframes bounce {

  0%,
  100% {
    transform: translateY(-8%);
    animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
  }

  50% {
    transform: translateY(0);
    animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
  }
}
</style>