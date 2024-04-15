<script setup>
import Services from './Services.vue';
import { Head} from '@inertiajs/vue3';
import userlayout from '@/Layouts/User/Layout.vue';

import { usePage } from '@inertiajs/vue3';

const page = usePage()
defineOptions({
    layout: userlayout,
});


</script>

<template>
    <Head title="Dashboard" />

    <div class=" items-center h-screen w-auto bg-slate-50 m-10 rounded-lg">
       <Services/>
       
    </div>
</template>