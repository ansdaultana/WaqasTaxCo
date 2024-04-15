<script setup>
import DashboardLayout from '@/Layouts/Vendor/DashboardLayout.vue';
import Form from './Form.vue'
import { useForm, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const page = usePage()
const product=computed(()=>page.props.product)
import { defineOptions } from 'vue';
defineOptions({
    layout: DashboardLayout,
});
</script>


<template>
    <div class="h-screen w-full bg-slate-100">

        <div class="flex items-center justify-center">
            <Form  :mode="'editProduct'" :product="product"/>

        </div>
    </div>
</template>