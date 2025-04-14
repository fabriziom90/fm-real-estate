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
                <div>
                    Applicativo di esempio per la gestione degli immobili e
                    delle proposte di acquisto.
                </div>
            </div>
        </div>
        <div class="container mx-auto mt-5">
            <div class="grid grid-cols-3 gap-4 text-center">
                <div class="bg-white p-5">
                    Inserimento di nuovi immobili, modifica e cancellazione di
                    quelli già esistenti.
                </div>
                <div class="bg-white p-5">
                    Inserimento delle proposte di acquisto, modifica e
                    cancellazione di quelle già esistenti.
                </div>
                <div class="bg-white p-5">
                    Visualizzazione del dettaglio della proposta di acquisto con
                    gli immobili e la loro percentuale di match con la richiesta
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
