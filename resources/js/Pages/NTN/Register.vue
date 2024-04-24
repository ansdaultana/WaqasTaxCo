<script setup>
import Services from '../User/Services.vue';
import UploadImageButton from '@/Components/UploadImageButton.vue';
import ImageBox from '@/Components/ImageBox.vue';
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import userlayout from '@/Layouts/User/Layout.vue';
defineOptions({
    layout: userlayout,
});
const acceptedImageTypes = ['image/jpeg', 'image/png'];

const form = useForm({
    images: [],
})
const fileInput = ref(null);
const ImagesViewLocal = ref([]);
const ImagesError = ref('');

const handleButtonClick = () => {
    fileInput.value.click();
};
const RemoveImage = (data) => {
    form.images.splice(data.index, 1);
    ImagesViewLocal.value = ImagesViewLocal.value.filter(image => image.url !== data.url);

}
const ImagesUpload = () => {
    const files = fileInput.value.files;

    for (const file of files) {
        if (acceptedImageTypes.includes(file.type)) {
            const imageUrl = URL.createObjectURL(file);

            if (ImagesViewLocal.value.length < 2) {
                ImagesViewLocal.value.push({ url: imageUrl });
                form.images.push(file);
            } else {
                ImagesError.value = 'Maximum of 2 images allowed.';
                break;
            }
        } else {
            ImagesError.value = 'Image is not in Jpeg or Png format.';
        }
    }
};
const submitForm = () => {
    if (form.images.length < 2) {
        ImagesError.value = 'Please Add at least 2 pictures.';
    } else {
        form.transform(data => ({
            ...data,
        })).post('/user/dashboard/ntn-register')
        .then(() => {
            // Reset the images field and clear the error message after form submission
            form.reset('images');
            ImagesViewLocal.value = [];
            ImagesError.value = '';
        })
        .catch((error) => {
            // Handle error if form submission fails
            console.error('Form submission error:', error);
            // You can also set an error message here if needed
        });
    }
};
</script>

<template>

    <Head title="NTN Register" />

    <div class=" items-center h-auto w-auto bg-slate-100 m-2 md:my-10 md:mx-20 p-10 rounded-lg">
        <div class="p-1 md:p-2">

            <div class="text-blue-500 text-lg  font-bold ">
                NTN Registration
            </div>
            <div class="h-1 w-full bg-blue-500 mt-5 rounded-full ">

            </div>

        </div>
        <div class="flex items-center justify-center">
            <div
                class="bg-white mt-4 md:mt-10 h-auto w-auto rounded-lg p-10 flex items-center justify-center hover:scale-103 transition-transform ease-in duration-100 ">
                <div class=" ">

                    <div class="flex items-center justify-center">
                        <div class="text-lg font-bold flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-7 h-7 text-blue-600  animate-pulse">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            <span class="pl-2 text-xl">
                                Register For NTN

                            </span>
                        </div>
                    </div>

                    <div class="md:text-sm md:p-5 p-2 text-xs">
                        Registering for NTN has been streamlined for your convenience.
                    </div>

                    <div class=" p-2 flex items-center justify-center text-xs md:text-sm">
                        <div>
                            <div class="">
                                Please upload your CNIC front
                                <span class="text-blue-600 font-bold">&</span> back
                            </div>

                            <div>
                                and the image must be clear.
                            </div>
                        </div>


                    </div>
                    <div class="flex items-center justify-center">
                        <div class="mt-2">
                            <!-- <InputLabel for="Images" value="Images"></InputLabel> -->
                            <div class="flex gap-x-2">

                                <div v-for="(image, index) in ImagesViewLocal" :key="index">
                                    <ImageBox :url="image.url" :index="index" @deleteImage="RemoveImage" />
                                </div>
                                <input class="hidden" type="file" ref="fileInput" @change="ImagesUpload" multiple>
                                <UploadImageButton @click.prevent="handleButtonClick" />

                            </div>
                            <div class="text-xs text-red-500">
                                {{ ImagesError }}
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-end mt-5 ">
                        <button @click.prevent="submitForm"
                            class="bg-blue-500 p-2 w-fit rounded-lg font-bold text-white hover:bg-blue-600 hover:scale-105 transition-transform ease-in-out duration-200 cursor-pointer">
                            Continue
                        </button>
                    </div>
                </div>

            </div>

        </div>


    </div>
</template>