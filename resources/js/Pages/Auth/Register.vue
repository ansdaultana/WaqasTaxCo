<script setup>
import { Head, Link, useForm,} from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { watch } from 'vue';
const form = useForm({
    name:'',
    cnic:'',
    phone_no: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});
watch(() => form.cnic, () => {
    formatCNIC();
});

watch(() => form.phone_no, () => {
    formatPhoneNumber();
});


const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const formatCNIC = () => {
    let cnic = form.cnic.replace(/[^0-9]/g, ''); // Remove non-numeric characters
   
    const formattedCNIC = cnic.replace(/(\d{5})(\d{7})(\d{1})/, '$1-$2-$3'); // Add dashes
    form.cnic = formattedCNIC;
};

const formatPhoneNumber = () => {
    let phoneNumber = form.phone_no.replace(/[^0-9]/g, ''); // Remove non-numeric characters
   
    form.phone_no = phoneNumber;
};

</script>

<template>
    <Head title="Register" />
    
    <GuestLayout>
        <form @submit.prevent="submit">
            
            <div >
                <InputLabel for="Name" value="Name" />
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />
    
                <InputError class="mt-2" :message="form.errors.name" />
            </div>
            <div class="mt-2">
                <InputLabel for="email" value="Email" />
    
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="email"
                />
    
                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <div class="mt-2">
                <InputLabel for="Cnic" value="Cnic" />
    
                <TextInput
                    id="cnic"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.cnic"
                    required
                    autofocus
                    placeholder="31303-1279536-3"
                    @input="formatCNIC"
                    />
    
                <InputError class="mt-2" :message="form.errors.cnic" />
            </div>
            <div class="mt-2">
                <InputLabel for="Phone Number" value="Phone Number" />
    
                <TextInput
                    id="phone_no"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.phone_no"
                    required
                    autofocus
                    autocomplete="tel"
                    placeholder="03005378021"
                    @input="formatPhoneNumber"
                />
    
                <InputError class="mt-2" :message="form.errors.phone_no" />
            </div>
            
            <div class="mt-2">
                <InputLabel for="password" value="Password" />
    
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />
    
                <InputError class="mt-2" :message="form.errors.password" />
            </div>
            <div class="mt-2">
                <InputLabel for="password_confirmation" value="Confirm Password" />
    
                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />
    
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>
            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-md text-blue-400 hover:text-blue-500 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                    Already registered? Sign In
                </Link>
    
                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
   
    
</template>
