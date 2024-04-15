
<script setup>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import Sidebar from '@/Components/Sidebar.vue';
import { ref, onUnmounted } from 'vue';

const openAccountMenu = ref(false);

const handleDocumentClick = (event) => {
    const accountMenu = document.getElementById('accountMenu');
    if (accountMenu && !accountMenu.contains(event.target)) {
        closeAccountMenu();
    }
};

const closeAccountMenu = () => {
    openAccountMenu.value = false;
};

document.body.addEventListener('click', handleDocumentClick);

// Ensure to remove the event listener when the component is unmounted
onUnmounted(() => {
    document.body.removeEventListener('click', handleDocumentClick);
});

const toggleopenAccountMenu = () => {
    openAccountMenu.value = !openAccountMenu.value;
};
</script>

<template>
    <div >
        <Navbar :openAccountMenu="openAccountMenu" @toggleopenAccountMenu="toggleopenAccountMenu"/>
        <!-- <Sidebar/> -->
        <slot/>
        <Footer/>
    </div>
</template>
