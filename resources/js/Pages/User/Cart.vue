<script setup>
import userlayout from '@/Layouts/User/Layout.vue';
import CartItem from '@/Components/CartItem.vue'
import { computed } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import {deleteCartItem} from '@/ActionsApi.js'
import {gotoDashboard} from '@/Navigation.js';


const page = usePage()
const CartItems = computed(() => page.props.cartItems);
const Cart= computed(() => page.props.cart);
const isEmpty= computed(() => page.props.isEmpty);
defineOptions({
    layout: userlayout,
});
const totalPrice = computed(() => {
    return CartItems.value.reduce((total, item) => total + item.price, 0);
});

const deleteItem=(data)=>
{
    deleteCartItem(Cart.value.id,data.item);

}
</script>

<template>

    <Head title="Dashboard" />

    <div class=" items-center h-auto w-auto bg-slate-100 m-2 md:my-10 md:mx-20 p-5 md:p-10 rounded-lg" :class="{ 'h-96': isEmpty }">

        <div class="p-1 md:p-2">

            <div class="text-blue-500 text-lg  font-bold ">
                Check Out
            </div>
            <div class="h-1 w-full bg-blue-500 mt-5 rounded-full ">

            </div>
            <div class="flex items-center justify-center  ">

                <div v-if="!isEmpty" class="md:w-96  bg-white mt-5 rounded-lg  p-5  shadow-md">
                    <div class="flex items-center justify-center mt-4">
                        <img class="w-auto h-40 rounded-lg" src="/Images/card5.png" alt="">

                    </div>
                    <div class="flex items-center justify-center p-4 text-lg ">
                        Items: <span class="pl-2 text-blue-500 font-bold" v-text="CartItems.length"></span>
                    </div>
                    <div class="w-full gap-y-2" v-for="(item, index) in CartItems" :key="index">
                        <CartItem :item="item" :name="item.name" @deleteFromCart="deleteItem"/>

                    </div>
                    <div class="bg-gray-200 border border-x-2 mb-5 mt-5">
                    </div>
                    <div class="flex p-2 items-center justify-between text-lg">

                        <span>Total</span>
                        <span class=" text-blue-500 font-bold">{{ Number(totalPrice).toLocaleString() }}</span>
                    </div>
                    <div class="bg-blue-500 text-white p-2 rounded-lg m-2 items-center flex justify-center hover:scale-103 transition-transform ease-in-out duration-200 cursor-pointer hover:bg-blue-600">
                        Proceed To Pay
                    </div>
                    <div>
                    </div>


                </div>
                    <div v-else class="bg-white mt-10 p-10 border-2 border-gray-100 rounded-lg  flex justify-between cursor-pointer transition-transform hover:scale-103  duration-200 ease-in ">
                        <div class="text-lg font-bold text-blue-500">
                            Your Cart is Empty
                        </div>
                        <div class=" hover:bg-slate-100 -mt-2 p-2 hover:text-blue-500 rounded-full ml-2" @click.prevent="gotoDashboard">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                              </svg>
                              
                        </div>
                    </div>
            </div>
        </div>

    </div>
</template>