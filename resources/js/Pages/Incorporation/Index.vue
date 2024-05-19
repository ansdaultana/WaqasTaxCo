<script setup>
import Card from '@/Components/Card.vue';
import { Head} from '@inertiajs/vue3';
import userlayout from '@/Layouts/User/Layout.vue';

defineOptions({
    layout: userlayout,
});


</script>

<template>
    <Head title="Dashboard" />

    <div class=" items-center h-screen w-auto bg-slate-50 m-10 rounded-lg">
        <div class="flex items-center justify-center  w-auto">
            <div>
                <h1 class="text-4xl mt-10 font-bold text-blue-500">Business Incorporation</h1>
            </div>
        </div>
        <div class="flex  items-center justify-center my-10">
            <div class="grid grid-cols-4 gap-x-20 gap-y-10 ">
                <Card title="Sole Proprietor" url="sole-proprietorship"/>
                <Card title="AOP / Partnership" url="aop"/>
                <Card title="Add Business to NTN" url="add-business-to-ntn"/>
                <Card title="Remove Business from NTN" url="remove-business-from-ntn"/>
            </div>
        
        </div>
    </div>
</template>