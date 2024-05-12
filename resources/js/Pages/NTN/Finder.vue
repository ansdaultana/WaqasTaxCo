<script setup>
import userlayout from '@/Layouts/User/Layout.vue';
import { ref } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import { FindNTN } from '@/ActionsApi.js'

defineOptions({
    layout: userlayout,
});
const Cnic = ref();
const Error = ref(false);
const Values = ref(null);
const Search = async () => {
    if (Cnic.value.length != 13) {
        Error.value = true
        return;
    }
    const CnicN = parseInt(Cnic.value);
    if (isNaN(CnicN)) {
        Error.value = true

        console.error('Invalid Cnic:', CnicN);
        return;
    }


    const { Data } = await FindNTN(CnicN);
    Values.value = Data;

}

</script>

<template>

    <Head title="NTN Finder" />

    <div class=" items-center h-auto w-auto bg-slate-100 m-2 md:my-5 md:mx-20 p-2 md:p-6 rounded-lg"
        :class="{ 'h-96': isEmpty }">

        <div class="p-1 md:p-1">

            <div class="text-blue-500 text-lg  font-bold ">
                NTN Finder
            </div>
            <div class="h-1 w-full bg-blue-500 mt-3 rounded-full ">

            </div>
            <div class="flex items-center justify-center">
                <div class="md:w-1/2  bg-white mt-5 rounded-lg p-5  shadow-md ">
                    <div class="md:flex   items-center justify-between md:p-3 text-sm  md:text-lg">
                        <div class="text-blue-500 p-2 md:p-0 font-bold ">

                            Enter Your 13 digits CNIC
                        </div>
                        <div class="flex md:items-center md:justify-center">
                            <div>
                                <input v-model="Cnic" class="rounded-lg mt-2 border w-32 md:w-52 mx-2 border-gray-400"
                                    type="text" placeholder="i.e 3325312407452">

                            </div>
                            <div class="flex mt-1 md:mt-2 items-center justify-end">
                                <button @click.prevent="Search" :disabled="!Cnic"
                                    class="bg-blue-500 items-center  p-3 md:p-2 mt-1 rounded-lg text-white hover:scale-103 transition-transform duration-200 ease-in-out cursor-pointer m-2 mr-2  hover:bg-blue-600 ">
                                    Search
                                </button>
                            </div>


                        </div>

                    </div>
                    <div v-if="Error"
                        class="text-red-500  text-xs md:text-sm m-1 md:-mt-2 flex items-center md:justify-end md:mr-28">
                        Enter 13 Digits Cnic without '-'
                    </div>
                    <div class="border-r border-l border-b  border-gray-200 mt-2">
                        <div class="bg-slate-100 p-2 ">
                            Details
                        </div>
                        <div class="flex">
                            <div class="w-1/2 text-xs md:text-base">

                                <div class="w-full h-14 p-3 border-b border-r border-gray-200">
                                    <span class="p-2  ">
                                        Name
                                    </span>

                                </div>
                                <div class="w-full h-14 p-3 border-b border-r border-gray-200">
                                    <span class="p-2  ">
                                        Registration No
                                    </span>

                                </div>
                                <div class="w-full h-14 p-3 border-b border-r border-gray-200">
                                    <span class="p-2  ">

                                        Reference No
                                    </span>

                                </div>
                                <div class="w-full h-14  p-3 border-b border-r border-gray-200">
                                    <span class="p-2  ">
                                        STRN
                                    </span>

                                </div>
                                <div class="w-full  h-14 p-3 border-b border-r border-gray-200">
                                    <span class="p-2  ">
                                        Category

                                    </span>

                                </div>
                                <div class="w-full h-14  p-3 border-b border-r border-gray-200">
                                    <span class="p-2  ">
                                        Registered On
                                    </span>

                                </div>
                                <div class="w-full p-3 h-14  border-b border-r border-gray-200">
                                    <span class="p-2  ">
                                        Tax Office
                                    </span>

                                </div>
                                <div class="w-full h-14  p-3 border-b border-r border-gray-200">
                                    <span class="p-2  ">
                                        Registration Status
                                    </span>

                                </div>
                                <div class="w-full p-3 h-40 md:h-28  border-b border-r border-gray-200">
                                    <span class="p-2  ">
                                        Address
                                    </span>

                                </div>

                            </div>
                            <div class="w-1/2 text-blue-500  text-xs md:text-base">

                                <div class="w-full p-3 h-14  border-b border-r border-gray-200">
                                    <span class="p-2  ">
                                        <span v-if="Values && Values.Name" v-text="Values.Name"></span>

                                    </span>

                                </div>
                                <div class="w-full p-3 h-14  border-b border-r border-gray-200">
                                    <span class="p-2  ">


                                        <span v-if="Values && Values.Registration_No"
                                            v-text="Values.Registration_No"></span>

                                    </span>

                                </div>
                                <div class="w-full p-3  h-14 border-b border-r border-gray-200">
                                    <span class="p-2  ">
                                        <span v-if="Values && Values.Reference_No" v-text="Values.Reference_No"></span>

                                    </span>

                                </div>
                                <div class="w-full p-3 h-14  border-b border-r border-gray-200">
                                    <span class="p-2  ">
                                        <span v-if="Values && Values.STRN" v-text="Values.STRN">

                                        </span>

                                    </span>

                                </div>
                                <div class="w-full p-3 h-14  border-b border-r border-gray-200">
                                    <span class="p-2  ">
                                        <span v-if="Values && Values.Category" v-text="Values.Category">

                                        </span>
                                    </span>

                                </div>
                                <div class="w-full p-3 h-14  border-b border-r border-gray-200">
                                    <span class="p-2  ">
                                        <span v-if="Values && Values.Registered_On"
                                            v-text="Values.Registered_On"></span>

                                    </span>

                                </div>
                                <div class="w-full p-3 h-14  border-b border-r border-gray-200">
                                    <span class="p-2  ">
                                        <span v-if="Values && Values.Tax_Office" v-text="Values.Tax_Office"></span>

                                    </span>

                                </div>
                                <div class="w-full p-3 h-14  border-b border-r border-gray-200">
                                    <span class="p-2  ">

                                        <span v-if="Values && Values.Registration_Status"
                                            v-text="Values.Registration_Status"></span>
                                    </span>

                                </div>
                                <div class="w-full p-3 h-40 md:h-28 border-b border-r border-gray-200">
                                    <span class="p-2 text-xs ">
                                        <span v-if="Values && Values.Address" v-text="Values.Address"></span>

                                    </span>

                                </div>


                            </div>
                        </div>
                    </div>


                </div>
            </div>


        </div>

    </div>
</template>