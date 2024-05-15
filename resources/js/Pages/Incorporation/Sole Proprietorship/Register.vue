<script setup>
import userlayout from '@/Layouts/User/Layout.vue';
import { ref, computed } from 'vue';
import BlueButton from '../../../Components/BlueButton.vue';
import { Head, usePage, useForm } from '@inertiajs/vue3';
import { sole_prop_upload_docs } from '@/Navigation.js'

defineOptions({
    layout: userlayout,
});


const page = usePage();
const UserDetails = page.props.UserDetails;
const sole_proprietorships = page.props.sole_proprietorships;
const newReg = ref(page.props.newReg || false);
const form = useForm({
    name: '',
    phone_no: UserDetails ? UserDetails.phone_no : '',
    email: UserDetails ? UserDetails.email : '',
});

const Submit = () => {
    form.post(route('sole_proprietorship.register'), {
    });
}
const gotoSoleProprietorship = (id) => {
    sole_prop_upload_docs(id);
}
const GotoNewSoleProp = () => {
    newReg.value = true;
}
</script>

<template>

    <Head title="Register" />

    <div class=" items-center h-auto w-auto bg-slate-100 m-2 md:my-5 md:mx-20 p-2 md:p-6 rounded-lg"
        :class="{ 'h-96': isEmpty }">

        <div class="p-1 md:p-1">

            <div class="text-blue-500 text-lg  font-bold ">
                Register
            </div>
            <div class="h-1 w-full bg-blue-500 mt-3 rounded-full ">

            </div>
            <div class="flex items-center justify-center">
                <div class="w-full md:w-1/2 lg:w-1/3  bg-white mt-5 rounded-lg p-5  shadow-md ">
                    <div v-if="newReg">
                        <div class="   items-center justify-center md:p-3 text-sm  md:text-lg">
                            <div class="text-blue-500 p-2 md:p-0 font-bold ">

                                Please Enter Details About Your Business
                            </div>
                        </div>

                        <div class="   items-center justify-between md:p-3 text-sm  md:text-base">
                            <div class="text-blue-500 p-2 md:p-0 font-bold ">

                                Enter Your Business Name
                            </div>
                            <div class="">
                                <input v-model="form.name" class="rounded-lg mt-2 w-full border-gray-300"
                                    placeholder="ABC" type="text">
                            </div>
                        </div>
                        <div class="  items-center justify-between md:p-3 text-sm  md:text-base">
                            <div class="text-blue-500 p-2 md:p-0 font-bold ">

                                Email
                            </div>
                            <div class="">
                                <input v-model="form.email" class="rounded-lg mt-2 w-full border-gray-300" type="text">
                            </div>
                        </div>
                        <div class="  items-center justify-between md:p-3 text-sm  md:text-base">
                            <div class="text-blue-500 p-2 md:p-0 font-bold ">

                                Phone Number
                            </div>
                            <div class="">
                                <input v-model="form.phone_no" class="rounded-lg mt-2 w-full border-gray-300"
                                    type="text">
                            </div>
                        </div>
                        <div class="flex items-center justify-end">
                            <button @click.prevent="Submit"
                                :disabled="!form || !form.name || !form.email || !form.phone_no"
                                class="text-white p-2 disabled:cursor-not-allowed mt-2 bg-blue-500 rounded-lg cursor-pointer hover:scale-105 transition-transform duration-300 ease-in-out">
                                Continue
                            </button>
                        </div>
                    </div>

                    <div v-if="!newReg">
                        <div class="   items-center justify-center md:p-3 text-sm  md:text-lg">
                            <div class="text-blue-500 p-2 md:p-0 font-bold ">

                                Continue
                            </div>
                            <div class="h-1 w-full bg-blue-500 mt-3 rounded-full ">

                            </div>
                        </div>
                        <div class="my-7">
                            <div   v-for="sole_proprietorship in sole_proprietorships">
                                <div
                                    class="flex mt-2 md:m-4 items-center p-3  bg-slate-100 rounded-lg justify-between  transition-transform hover:scale-103 duration-300">
                                    <span v-text="sole_proprietorship['name']"></span>
                                    <div>
                                        <BlueButton text="Continue"
                                            @click.prevent="gotoSoleProprietorship(sole_proprietorship['id'])" />
                                    </div>
                                </div>
                            </div>
                        </div>
                      
                        <div class="flex items-center justify-end mt-10 ">
                            <BlueButton text="Register  New" @click.prevent="GotoNewSoleProp" />

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</template>