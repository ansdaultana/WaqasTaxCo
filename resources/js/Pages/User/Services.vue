<script setup>
import Card from '@/Components/Card.vue';
</script>


<template>

    <div class="flex items-center justify-center  w-auto">
        <div>
            <h1 class="text-4xl mt-10 font-bold text-blue-500">Services</h1>
        </div>
    </div>
    <div class="flex  items-center justify-center my-10">
        <div class="grid grid-cols-4 gap-x-20 ">
            <Card title="Personal Tax Filing" url="personal-tax"/>
            <Card title="Family Tax filing" url="family-tax"/>
            <Card title="NTN Registration" url="ntn-index"/>
            <Card title="NTN Finder" url="ntn-finder"/>
    
        </div>
    
    </div>
 </template>