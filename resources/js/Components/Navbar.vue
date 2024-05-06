<script setup>
import NavbarButton from './NavbarButton.vue';
import { logout } from '@/Navigation';
import { gotoHome } from '@/Navigation';
import { usePage } from '@inertiajs/vue3';
const page = usePage();
const user = page.props.auth.user;
const emit = defineEmits(['toggleopenAccountMenu'])

defineProps({
    openAccountMenu: Boolean
})

const ToggleopenAccountMenu = () => {
    emit('toggleopenAccountMenu')
}
</script>

<template>
    <div>
        <div
            class="cursor-pointer flex justify-between w-full p-2  items-center text-xs md:text-sm  rounded-xxl bg-slate-100 rounded-b-md">
            <div class="flex justify-between  w-auto p-2" @click="gotoHome">

                <span class="font-extrabold text-2xl text-blue-500">Waqas</span>
                <span class="text-2xl ml-1"> &</span>

                <span class="ml-1 font-extrabold text-2xl text-blue-500">Co</span>

                <div class="  font-bold">

                </div>


            </div>


            <div class="flex justify-between w-auto gap-2 font-bold">

                <div class="relative">
                    <div id="accountMenu" @click.prevent="ToggleopenAccountMenu"
                        class="rounded-full p-1.5 bg-blue-500 w-auto  cursor-pointer transition-transform hover:scale-105 duration-200 ease-in">
                        <span class="p-2 text-white text-xl " v-text="user.name.charAt(0).toUpperCase()"></span>
                    </div>
                    <transition      name="fade">

                        <div id="accountMenu"  v-show="openAccountMenu"
                            class="absolute p-5 bg-slate-50 w-auto h-auto right-5 rounded-lg border-gray-400 border transition-transform hover:scale-103 duration-300 ease-in-out">
                            <div class=" items-center flex justify-center ">
                                <div
                                    class="rounded-full p-1.5 bg-blue-500  cursor-pointer transition-transform hover:scale-105 duration-200 ease-in">
                                    <span class="p-2 text-white text-xl"
                                        v-text="user.name.charAt(0).toUpperCase()"></span>
                                </div>
                                <div class="p-1 w-20 text-gray-800 md:w-24">
                                    <span v-text="user.name.charAt(0).toUpperCase() + user.name.slice(1)"></span>
                                </div>
                                <div
                                
                                    class=" hover:bg-slate-100 flex rounded-lg  p-2 border bg-white border-gray-400 cursor-pointer transition-transform hover:scale-103 duration-500 ease-in">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-5 mr-1  animate-spin">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                      </svg>
                                      
                                    <span class="w-14 md:w-28"> Account Setting</span>
                                </div>
                                <div class="p-2 hover:text-red-400 cursor-pointer" @click.prevent="logout">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                                    </svg>

                                </div>
                            </div>
                        </div>
                    </transition>

                </div>
            </div>

        </div>

    </div>
</template>
<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.4s;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}
</style>