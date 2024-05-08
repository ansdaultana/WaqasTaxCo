<script setup>
import userlayout from '@/Layouts/User/Layout.vue';
import CartItem from '@/Components/CartItem.vue'
import { computed, ref } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import { CalculateSalaryTax } from '@/ActionsApi.js'
import { watch } from 'vue';

const page = usePage()
defineOptions({
    layout: userlayout,
});
const MonthlySalary=ref();
const Monthlytax = ref(null);
const Yearlytax = ref(null);

const Calculate = async () => {
    const monthlySalaryValue = parseInt(MonthlySalary.value);
    if (isNaN(monthlySalaryValue)) {
        console.error('Invalid monthly salary:', MonthlySalary.value);
        return;
    }

    const { MonthlytaxAmount, YearlytaxAmount } = await CalculateSalaryTax(monthlySalaryValue);
    

    Monthlytax.value = MonthlytaxAmount;
    Yearlytax.value = YearlytaxAmount;
}

watch(MonthlySalary, () => {
    Monthlytax.value = null;
    Yearlytax.value = null;
});
</script>

<template>

    <Head title="Salary Calculator" />

    <div class=" items-center h-auto w-auto bg-slate-100 m-2 md:my-10 md:mx-20 p-5 md:p-10 rounded-lg"
        :class="{ 'h-96': isEmpty }">

        <div class="p-1 md:p-2">

            <div class="text-blue-500 text-lg  font-bold ">
                Salary Calculator
            </div>
            <div class="h-1 w-full bg-blue-500 mt-5 rounded-full ">

            </div>
            <div class="flex items-center justify-center">
                <div class="md:w-1/2  bg-white mt-5 rounded-lg  p-5  shadow-md ">
                    <div class="flex items-center justify-between p-5 text-sm md:text-lg">
                        <div>
                            Enter Your Monthly Salary
                        </div>
                        <div>
                            <input v-model="MonthlySalary" class="rounded-lg border w-32 mx-2 border-gray-400" type="text" placeholder="i.e 70000">
                        </div>
                    </div>
                    <div class="flex items-center justify-end">
                        <button @click.prevent="Calculate" :disabled="!MonthlySalary"
                            class="bg-blue-500 items-center p-2 rounded-lg text-white hover:scale-103 transition-transform duration-200 ease-in-out cursor-pointer mr-5 hover:bg-blue-600 ">
                            Calculate
                        </button>
                    </div>
                    <div class="border-r border-l border-b  border-gray-200 mt-2">
                        <div class="bg-slate-100 p-2 ">
                            Details
                        </div>
                        <div>
                            <div class="p-2 text-blue-500 font-bold text-lg">
                                Monthly
                            </div>
                            <div class="p-2 -mt-1 ">
                                <div class="flex items-center justify-between px-5">
                                    <span>Salary</span>
                                    <span v-text="MonthlySalary?MonthlySalary.toLocaleString():null"></span>
                                    
                                </div>
                                <div class="flex items-center justify-between px-5">
                                    <span>Tax</span>
                                    <span v-text="Monthlytax?Monthlytax.toLocaleString():null"></span>
                                    
                                </div>
                                <div class="flex items-center justify-between px-5">
                                    <span>Salary After Tax</span>
                                    <span v-text=" MonthlySalary && Monthlytax ?(MonthlySalary-Monthlytax).toLocaleString():null"></span>
                                    
                                </div>
                            </div>
                          </div>
                          <div>
                            <div class="p-2 text-blue-500 font-bold text-lg">
                                Yearly
                            </div>
                            <div class="p-2 -mt-1 ">
                                <div class="flex items-center justify-between px-5">
                                    <span>Salary</span>
                                    <span v-text="MonthlySalary?(MonthlySalary*12).toLocaleString():0"></span>
                                    
                                </div>
                                <div class="flex items-center justify-between px-5">
                                    <span>Tax</span>
                                    <span v-text="Yearlytax?Yearlytax.toLocaleString():null"></span>
                                    
                                </div>
                                <div class="flex items-center justify-between px-5">
                                    <span>Salary After Tax</span>
                                    <span v-text=" MonthlySalary && Yearlytax ? (MonthlySalary*12-Yearlytax).toLocaleString():null"></span>
                                    
                                </div>
                            </div>
                          </div>

                    </div>


                </div>
            </div>


        </div>

    </div>
</template>