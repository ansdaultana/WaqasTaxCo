<script setup>
import userlayout from '@/Layouts/User/Layout.vue';
import { ref, computed } from 'vue';
import { Head, usePage, useForm } from '@inertiajs/vue3';
import { watch } from 'vue';

defineOptions({
    layout: userlayout,
});


const page = usePage();
const Aop = page.props.Aop;
const documents = computed(() => page.props.documents)
const deleted = ref(null)
const Error = ref('');

const form = useForm({
    partnership_deed: null,
    partnership_registration_certificate: null,
    authority_letter: [],
    cnic: [],
    rent_agreement: [],
    letterhead: null,
    electricity_bill: null,
    deleted: [],
    update: documents.value.length > 0 ? true : false
});

if (documents) {
    for (let index = 0; index < documents.value.length; index++) {
        const element = documents.value[index];

        if (element.what_for === 'cnic') {
            form.cnic.push({
                name: element.name,
                id: element.id,
                what_for: element.what_for,
                type: element.type
            });
        } else if (element.what_for === 'letterhead') {
            form.letterhead = {
                name: element.name,
                id: element.id,
                what_for: element.what_for,
                type: element.type
            };
        } else if (element.what_for === 'electricity_bill') {
            form.electricity_bill = {
                name: element.name,
                id: element.id,
                what_for: element.what_for,
                type: element.type
            };
        } else if (element.what_for === 'partnership_deed') {
            form.partnership_deed = {
                name: element.name,
                id: element.id,
                what_for: element.what_for,
                type: element.type
            };
        } else if (element.what_for === 'partnership_registration_certificate') {
            form.partnership_registration_certificate = {
                name: element.name,
                id: element.id,
                what_for: element.what_for,
                type: element.type
            };
        } else if (element.what_for === 'rent_agreement') {
            form.rent_agreement.push({
                name: element.name,
                id: element.id,
                what_for: element.what_for,
                type: element.type
            });
        }
        else if (element.what_for === 'authority_letter') {
            form.authority_letter.push({
                name: element.name,
                id: element.id,
                what_for: element.what_for,
                type: element.type
            });
        }
    }
}
const MAX_FILE_SIZE_MB = 2; // Maximum file size allowed in MB
const ALLOWED_FILE_TYPES = ['image/jpeg', 'image/png', 'application/pdf']; // Allowed file types

const handleFileChange = (event, fieldName) => {
    const file = event.target.files[0];

    if (!file) {
        return;
    }

    if (!ALLOWED_FILE_TYPES.includes(file.type)) {
        Error.value = 'Please upload an image (JPEG or PNG) or a PDF file.';
        return;
    }

    const fileSizeMB = file.size / (1024 * 1024); // Convert bytes to MB
    if (fileSizeMB > MAX_FILE_SIZE_MB) {
        Error.value = `File size exceeds the limit of ${MAX_FILE_SIZE_MB} MB.`
        return;
    }


    if (form[fieldName] && form[fieldName].id) {
        form.deleted.push(form[fieldName]);
    }
    form[fieldName] = file;
};
const handleFileChangeForMultiple = (event, fieldName) => {
    const files = event.target.files;


    if (!files) {
        return;
    }
    if (files.length < 0 || files.length > 3) {
        Error.value = "You Can Only Upload 3 Documents for these 'authority_letter , rent_agreement , cnic'";
        return;
    }
    for (let index = 0; index < files.length; index++) {
        const file = files[index];
        if (!ALLOWED_FILE_TYPES.includes(file.type)) {
            Error.value = 'Please upload an image (JPEG or PNG) or a PDF file.';
            return;
        }

        const fileSizeMB = file.size / (1024 * 1024); // Convert bytes to MB
        if (fileSizeMB > MAX_FILE_SIZE_MB) {
            Error.value = `File size exceeds the limit of ${MAX_FILE_SIZE_MB} MB.`
            return;
        }
        form[fieldName].push(file);

    }

};

const triggerFileInput = (fieldName) => {
    document.getElementById(fieldName).click();
};
const Submit = () => {
    form.post(`/user/dashboard/aop/upload-docs/${Aop.id}`);
}
const RemoveCnic = () => {

    if (form.cnic[0].id) {
        form.deleted.push(form.cnic);
    }
    form.cnic = [];
}
const RemoveAuthority_letter = () => {

    if (form.authority_letter[0].id) {
        form.deleted.push(form.authority_letter);
    }
    form.authority_letter = [];
}
const RemoveRent_agreement = () => {

    if (form.rent_agreement[0].id) {
        form.deleted.push(form.rent_agreement);
    }
    form.rent_agreement = [];
}
const RemoveElectricity_bill = () => {
    if (form.electricity_bill.id) {
        form.deleted.push(form.electricity_bill);
    }
    form.electricity_bill = null;
}
const RemoveLetterhead = () => {
    if (form.letterhead.id) {
        form.deleted.push(form.letterhead);
    }
    form.letterhead = null;
}
const RemovePartnership_deed = () => {
    if (form.partnership_deed.id) {
        form.deleted.push(form.partnership_deed);
    }
    form.partnership_deed = null;
}
const RemovePartnership_registration_certificate = () => {
    if (form.partnership_registration_certificate.id) {
        form.deleted.push(form.partnership_registration_certificate);
    }
    form.partnership_registration_certificate = null;
}

</script>

<template>

    <Head title="Upload Documents" />

    <div class=" items-center h-auto w-auto bg-slate-100 m-2 md:my-5 md:mx-20 p-2 md:p-6 rounded-lg"
        :class="{ 'h-96': isEmpty }">

        <div class="p-1 md:p-1">

            <div class="text-blue-500 text-lg  font-bold ">
                Upload Documents
            </div>
            <div class="h-1 w-full bg-blue-500 mt-3 rounded-full ">

            </div>
            <div class="flex items-center justify-center">
                <div class="w-full md:w-3/4  bg-white mt-5 rounded-lg p-2 md:p-5  shadow-md ">
                    <div class="   items-center justify-center md:p-3 text-sm  md:text-lg">
                        <div class="text-blue-500 p-2 md:p-0 font-bold ">

                            Please Upload The Following Documents
                        </div>
                    </div>


                    <div class="m-2" v-if="Error">
                        <span class="text-red-600 " v-text="Error"></span>
                    </div>
                    <div>
                        <div class="h-1 w-full bg-blue-500 mt-3 rounded-full ">

                        </div>
                        <div class=" text-blue-500 mt-5 font-bold">
                            Your Documents
                        </div>

                        <div class="text-xs md:text-sm">

                            <div>
                                <div class="p-4 bg-slate-100 rounded-lg m-2 flex justify-between">
                                    <div class="flex">
                                        <div class="flex items-center justify-center text-blue-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                            </svg>
                                        </div>
                                        <div class="flex items-center ml-5">
                                            <span class="text-blue-500 font-bold mr-5">Partnership deed, signed and
                                                registered with the Registrar of Firms</span>
                                        </div>

                                    </div>
                                    <div class="flex gap-x-2">
                                        <input type="file" id="partnership_deed"
                                            @change="e => handleFileChange(e, 'partnership_deed')" class="hidden" />

                                        <div @click="triggerFileInput('partnership_deed')"
                                            :class="{ 'bg-emerald-100 text-green-600': form.partnership_deed }"
                                            class="bg-white p-1 hover:text-blue-500 rounded-full hover:bg-blue-100 cursor-pointer mt-1.5 h-8 item-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                            </svg>

                                        </div>
                                        <div @click.prevent="RemovePartnership_deed"
                                            class="bg-white p-1 hover:text-red-500 rounded-full hover:bg-red-100 cursor-pointer mt-2 h-8">

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18 18 6M6 6l12 12" />
                                            </svg>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div>
                                <div class="p-4 bg-slate-100 rounded-lg m-2 flex justify-between">
                                    <div class="flex">
                                        <div class="flex items-center justify-center text-blue-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                            </svg>
                                        </div>
                                        <div class="flex items-center ml-5">
                                            <span class="text-blue-500 font-bold mr-5">Partnership Registration
                                                Certificate issued by the Registrar of Firms</span>
                                        </div>

                                    </div>
                                    <div class="flex gap-x-2">
                                        <input type="file" id="partnership_registration_certificate"
                                            @change="e => handleFileChange(e, 'partnership_registration_certificate')"
                                            class="hidden" />

                                        <div @click="triggerFileInput('partnership_registration_certificate')"
                                            :class="{ 'bg-emerald-100 text-green-700': form.partnership_registration_certificate }"
                                            class="bg-white p-1 hover:text-blue-500 rounded-full hover:bg-blue-100 cursor-pointer mt-1.5 h-8">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                            </svg>

                                        </div>
                                        <div @click.prevent="RemovePartnership_registration_certificate"
                                            class="bg-white p-1 hover:text-red-500 rounded-full hover:bg-red-100 cursor-pointer mt-2 h-8">

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18 18 6M6 6l12 12" />
                                            </svg>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div>
                                <div class="p-4 bg-slate-100 rounded-lg m-2 flex justify-between">
                                    <div class="flex">
                                        <div class="flex items-center justify-center text-blue-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                            </svg>
                                        </div>
                                        <div class="flex items-center ml-5">
                                            <span class="text-blue-500 font-bold mr-5">Colored copies of CNICs of all
                                                partners</span>
                                        </div>

                                    </div>
                                    <div class="flex gap-x-2">
                                        <input type="file" id="cnic"
                                            @change="e => handleFileChangeForMultiple(e, 'cnic')" multiple
                                            class="hidden" />

                                        <div @click="triggerFileInput('cnic')"
                                            :class="{ 'bg-emerald-100 text-green-700': (form.cnic && form.cnic.length > 0) }"
                                            class="bg-white p-1 hover:text-blue-500 rounded-full hover:bg-blue-100 cursor-pointer mt-1.5 h-8">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                            </svg>

                                        </div>
                                        <div @click.prevent="RemoveCnic"
                                            class="bg-white p-1 hover:text-red-500 rounded-full hover:bg-red-100 cursor-pointer mt-2 h-8">

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18 18 6M6 6l12 12" />
                                            </svg>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div>
                                <div class="p-4 bg-slate-100 rounded-lg m-2 flex justify-between">
                                    <div class="flex">
                                        <div class="flex items-center justify-center text-blue-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                            </svg>
                                        </div>
                                        <div class="flex items-center ml-5">
                                            <span class="text-blue-500 font-bold mr-5">Authorization letter for a
                                                partner to act on behalf of the partnership</span>
                                        </div>

                                    </div>
                                    <div class="flex gap-x-2">
                                        <input type="file" id="authority_letter"
                                            @change="e => handleFileChangeForMultiple(e, 'authority_letter')" multiple
                                            class="hidden" />

                                        <div @click="triggerFileInput('authority_letter')"
                                            :class="{ 'bg-emerald-100 text-green-700': form.authority_letter && form.authority_letter.length > 0 }"
                                            class="bg-white p-1 hover:text-blue-500 rounded-full hover:bg-blue-100 cursor-pointer mt-1.5 h-8">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                            </svg>

                                        </div>
                                        <div @click.prevent="RemoveAuthority_letter"
                                            class="bg-white p-1 hover:text-red-500 rounded-full hover:bg-red-100 cursor-pointer mt-2 h-8">

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18 18 6M6 6l12 12" />
                                            </svg>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div>
                                <div class="p-4 bg-slate-100 rounded-lg m-2 flex justify-between">
                                    <div class="flex">
                                        <div class="flex items-center justify-center text-blue-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                            </svg>
                                        </div>
                                        <div class="flex items-center ml-5">
                                            <span class="text-blue-500 font-bold mr-5">Rent agreement or ownership
                                                documents for the registered office</span>
                                        </div>

                                    </div>
                                    <div class="flex gap-x-2">
                                        <input type="file" id="rent_agreement"
                                            @change="e => handleFileChangeForMultiple(e, 'rent_agreement')" multiple
                                            class="hidden" />

                                        <div @click="triggerFileInput('rent_agreement')"
                                            :class="{ 'bg-emerald-100 text-green-700': form.rent_agreement && form.rent_agreement.length > 0 }"
                                            class="bg-white p-1 hover:text-blue-500 rounded-full hover:bg-blue-100 cursor-pointer mt-1.5 h-8">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                            </svg>

                                        </div>
                                        <div @click.prevent="RemoveRent_agreement"
                                            class="bg-white p-1 hover:text-red-500 rounded-full hover:bg-red-100 cursor-pointer mt-2 h-8">

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18 18 6M6 6l12 12" />
                                            </svg>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div>
                                <div class="p-4 bg-slate-100 rounded-lg m-2 flex justify-between">
                                    <div class="flex">
                                        <div class="flex items-center justify-center text-blue-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                            </svg>
                                        </div>
                                        <div class="flex items-center ml-5">
                                            <span class="text-blue-500 font-bold mr-5">Firm's letterhead</span>
                                        </div>

                                    </div>
                                    <div class="flex gap-x-2">
                                        <input type="file" id="letterhead"
                                            @change="e => handleFileChange(e, 'letterhead')" class="hidden" />

                                        <div @click="triggerFileInput('letterhead')"
                                            :class="{ 'bg-emerald-100 text-green-700': form.letterhead }"
                                            class="bg-white p-1 hover:text-blue-500 rounded-full hover:bg-blue-100 cursor-pointer mt-1.5 h-8">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                            </svg>

                                        </div>
                                        <div @click.prevent="RemoveLetterhead"
                                            class="bg-white p-1 hover:text-red-500 rounded-full hover:bg-red-100 cursor-pointer mt-2 h-8">

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18 18 6M6 6l12 12" />
                                            </svg>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div>
                                <div class="p-4 bg-slate-100 rounded-lg m-2 flex justify-between">
                                    <div class="flex">
                                        <div class="flex items-center justify-center text-blue-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                            </svg>
                                        </div>
                                        <div class="flex items-center ml-5">
                                            <span class="text-blue-500 font-bold mr-5">Latest paid electricity bill for
                                                the registered office</span>
                                        </div>

                                    </div>
                                    <div class="flex gap-x-2">
                                        <input type="file" id="electricity_bill"
                                            @change="e => handleFileChange(e, 'electricity_bill')" class="hidden" />

                                        <div @click="triggerFileInput('electricity_bill')"
                                            :class="{ 'bg-emerald-100 text-green-700': form.electricity_bill }"
                                            class="bg-white p-1 hover:text-blue-500 rounded-full hover:bg-blue-100 cursor-pointer mt-1.5 h-8">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                            </svg>

                                        </div>
                                        <div @click.prevent="RemoveElectricity_bill"
                                            class="bg-white p-1 hover:text-red-500 rounded-full hover:bg-red-100 cursor-pointer mt-2 h-8">

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18 18 6M6 6l12 12" />
                                            </svg>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="flex items-center justify-end">

                        <button @click.prevent="Submit"
                            :disabled="!form || form.cnic.length === 0 || form.authority_letter.length === 0 || form.rent_agreement.length === 0 || !form.partnership_deed || !form.partnership_registration_certificate || !form.letterhead || !form.electricity_bill"
                            class="text-white mt-10 p-2 disabled:cursor-not-allowed bg-blue-500 rounded-lg cursor-pointer hover:scale-105 transition-transform duration-300 ease-in-out">
                            Continue
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</template>