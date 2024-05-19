<script setup>
import userlayout from '@/Layouts/User/Layout.vue';
import { ref, computed } from 'vue';
import { Head, usePage, useForm } from '@inertiajs/vue3';

defineOptions({
    layout: userlayout,
});


const page = usePage();
const SP = page.props.SP;
const images = computed(() => page.props.images)
const pdfs = computed(() => page.props.pdfs)
const deleted = ref(null)
const Error = ref('');

const form = useForm({
    cnic: null,
    letterhead: null,
    utility_bill: null,
    rental_agreement: null,
    deleted:[],
    update:images.value.length > 0 || pdfs.value.length > 0  ? true : false
});

if (images) {
    for (let index = 0; index < images.value.length; index++) {
        const element = images.value[index];

        if (element.what_for === 'cnic') {
            form.cnic = {
                name: element.name,
                id: element.id,
                what_for: element.what_for,
                type:element.type
            };
        }

        if (element.what_for === 'letterhead') {
            form.letterhead = {
                name: element.name,
                id: element.id,
                what_for: element.what_for,
                type:element.type
            };
        }

        if (element.what_for === 'utility_bill') {
            form.utility_bill = {
                name: element.name,
                id: element.id,
                what_for: element.what_for,
                type:element.type
            };
        }

        if (element.what_for === 'rental_agreement') {
            form.rental_agreement = {
                name: element.name,
                id: element.id,
                what_for: element.what_for,
                type:element.type
            };
        }

    }
}
if (pdfs) {
    for (let index = 0; index < pdfs.value.length; index++) {
        const element = pdfs.value[index];

        if (element.what_for === 'cnic') {
            form.cnic = {
                name: element.name,
                id: element.id,
                what_for: element.what_for,
                type:element.type
            };
        }

        if (element.what_for === 'letterhead') {
            form.letterhead = {
                name: element.name,
                id: element.id,
                what_for: element.what_for,
                type:element.type
            };
        }

        if (element.what_for === 'utility_bill') {
            form.utility_bill = {
                name: element.name,
                id: element.id,
                what_for: element.what_for,
                type:element.type
            };
        }

        if (element.what_for === 'rental_agreement') {
            form.rental_agreement = {
                name: element.name,
                id: element.id,
                what_for: element.what_for,
                type:element.type
            };
        }

    }
}
const MAX_FILE_SIZE_MB = 2; // Maximum file size allowed in MB
const ALLOWED_FILE_TYPES = ['image/jpeg', 'image/png', 'application/pdf']; // Allowed file types

const handleFileChange = (event, fieldName) => {
    const file = event.target.files[0];

    // Check if a file is selected
    if (!file) {
        // Handle case where no file is selected
        return;
    }

    // Check file type
    if (!ALLOWED_FILE_TYPES.includes(file.type)) {
        Error.value = 'Please upload an image (JPEG or PNG) or a PDF file.';
        return;
    }

    // Check file size
    const fileSizeMB = file.size / (1024 * 1024); // Convert bytes to MB
    if (fileSizeMB > MAX_FILE_SIZE_MB) {
        Error.value = `File size exceeds the limit of ${MAX_FILE_SIZE_MB} MB.`
        return;
    }

    // If file passes all checks, update the form data
    
    if (form[fieldName] &&form[fieldName].id) {
        form.deleted.push(form[fieldName]);
    }
    form[fieldName] = file;
};


const triggerFileInput = (fieldName) => {
    document.getElementById(fieldName).click();
};
const Submit = () => {
    form.post(`/user/dashboard/sole-proprietorship/upload-docs/${SP.id}`);
}
const RemoveCnic = () => {
    if (form.cnic.id) {
        form.deleted.push(form.cnic);
    }
    form.cnic = null;
}

const RemoveLetterHead = () => {
    if (form.letterhead.id) {
        form.deleted.push(form.letterhead);
    }
    form.letterhead = null;

}
const RemoveRentalAgreement = () => {
    if (form.rental_agreement.id) {
        form.deleted.push(form.rental_agreement);
    }
    form.rental_agreement = null;

}
const RemoveUtilityBill = () => {
    if (form.utility_bill.id) {
        form.deleted.push(form.utility_bill);
    }
    form.utility_bill = null;

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
                    <div class="grid grid-cols-2 gap-2 lg:grid-cols-4 m-1 md:m-5">
                        <div @click="triggerFileInput('cnic')"
                            class="bg-white cursor-pointer shadow-sm h-36 w-40 p-2 rounded-lg border-gray-100 border-2 transition-transform hover:scale-103 duration-200 ease-out">
                            <input type="file" id="cnic" @change="e => handleFileChange(e, 'cnic')" class="hidden" />
                            <div class="flex items-center justify-center text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-16 h-16">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                            </div>
                            <span class="text-xs mt-3 flex items-center justify-center">Color Copy of CNIC</span>
                        </div>
                        <div @click="triggerFileInput('letterhead')"
                            class="bg-white cursor-pointer shadow-sm h-36 w-40 p-2 rounded-lg border-gray-100 border-2 transition-transform hover:scale-103 duration-200 ease-out">
                            <input type="file" id="letterhead" @change="e => handleFileChange(e, 'letterhead')"
                                class="hidden" />
                            <div class="flex items-center justify-center text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-16 h-16">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                            </div>
                            <span class="text-xs mt-3 flex items-center justify-center">Company's Letterhead</span>
                        </div>
                        <div @click="triggerFileInput('utility_bill')"
                            class="bg-white cursor-pointer shadow-sm h-36 w-40 p-2 rounded-lg border-gray-100 border-2 transition-transform hover:scale-103 duration-200 ease-out">
                            <input type="file" id="utility_bill" @change="e => handleFileChange(e, 'utility_bill')"
                                class="hidden" />
                            <div class="flex items-center justify-center text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-16 h-16">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                            </div>
                            <span class="text-xs mt-3 flex items-center justify-center">Utility Bill (Last Paid)</span>
                        </div>
                        <div @click="triggerFileInput('rental_agreement')"
                            class="bg-white cursor-pointer shadow-sm h-36 w-40 p-2 rounded-lg border-gray-100 border-2 transition-transform hover:scale-103 duration-200 ease-out">
                            <input type="file" id="rental_agreement"
                                @change="e => handleFileChange(e, 'rental_agreement')" class="hidden" />
                            <div class="flex items-center justify-center text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-16 h-16">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                            </div>
                            <span class="text-xs mt-3 flex items-center justify-center">Rental Agreement or</span>
                            <span class="text-xs mt-3 flex items-center justify-center"> Ownership Document</span>
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
                        <div v-if="!form.cnic && !form.letterhead && !form.rental_agreement && !form.utility_bill">
                            <span class="flex items-center justify-center my-5">No Documents Have been Upload!</span>
                        </div>
                        <div v-else>
                            <div v-if="form.cnic" class="p-4 bg-slate-100 rounded-lg m-2 flex justify-between">

                                <div>
                                    <span class="text-blue-500 font-bold mr-5">CNIC</span>
                                    <span class="" v-text="form.cnic.name"></span>
                                </div>
                                <div @click.prevent="RemoveCnic"
                                    class="bg-white p-1 hover:text-red-500 rounded-full hover:bg-red-100 cursor-pointer">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </div>
                            </div>
                            <div v-if="form.letterhead" class="p-4 bg-slate-100 rounded-lg m-2 flex justify-between">

                                <div>
                                    <span class="text-blue-500 font-bold mr-5">Letterhead</span>
                                    <span class="" v-text="form.letterhead.name"></span>
                                </div>
                                <div @click.prevent="RemoveLetterHead"
                                    class="bg-white p-1 hover:text-red-500 rounded-full hover:bg-red-100 cursor-pointer">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </div>
                            </div>
                            <div v-if="form.utility_bill" class="p-4 bg-slate-100 rounded-lg m-2 flex justify-between">

                                <div>
                                    <span class="text-blue-500 font-bold mr-5">Utility Bill</span>
                                    <span class="" v-text="form.utility_bill.name"></span>
                                </div>
                                <div @click.prevent="RemoveUtilityBill"
                                    class="bg-white p-1 hover:text-red-500 rounded-full hover:bg-red-100 cursor-pointer">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </div>
                            </div>
                            <div v-if="form.rental_agreement"
                                class="p-4 bg-slate-100 rounded-lg m-2 flex justify-between">

                                <div>
                                    <span class="text-blue-500 font-bold mr-5">Rental / Ownership</span>
                                    <span class="" v-text="form.rental_agreement.name"></span>
                                </div>
                                <div @click.prevent="RemoveRentalAgreement"
                                    class="bg-white p-1 hover:text-red-500 rounded-full hover:bg-red-100 cursor-pointer">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-end">

                        <button @click.prevent="Submit"
                            :disabled="!form || !form.cnic || !form.letterhead || !form.utility_bill || !form.rental_agreement"
                            class="text-white mt-10 p-2 disabled:cursor-not-allowed bg-blue-500 rounded-lg cursor-pointer hover:scale-105 transition-transform duration-300 ease-in-out">
                            Continue
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</template>