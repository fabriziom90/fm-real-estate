<script setup>
import Header from "@/Components/Header.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <GuestLayout :canLogin="canLogin" :canRegister="canRegister">
        <div class="container mx-auto mt-5 bg-white p-5">
            <div class="grid grid-cols-1 text-center">
                <h1 class="text-[50px]">FM Real Estate</h1>
                <div>Lorem ipsum dolor sit amet</div>
            </div>
        </div>
        <div class="container mx-auto mt-5">
            <div class="grid grid-cols-3 gap-4 text-center">
                <div class="bg-white p-5">Lorem ipsum dolor sit amet</div>
                <div class="bg-white p-5">Lorem ipsum dolor sit amet</div>
                <div class="bg-white p-5">Lorem ipsum dolor sit amet</div>
            </div>
        </div>
    </GuestLayout>
</template>
