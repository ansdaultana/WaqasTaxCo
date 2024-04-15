<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { router } from '@inertiajs/vue3';
const gotohome=()=>{
    router.get('/');
}
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header >
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
            <button @click.prevet="gotohome" class="p-4 bg-blue-400 rounded-xl">
                Home
            </button>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Welcome />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
