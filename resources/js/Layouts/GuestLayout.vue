<script setup>
import { Link } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import Header from "../Components/Header.vue";

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
    <Header :canLogin="canLogin" :canRegister="canRegister" />
    <main>
        <slot />
    </main>
</template>
